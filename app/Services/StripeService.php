<?php

namespace App\Services;

use Illuminate\Http\Request;

use App\Traits\ConsumesExternalServices;

class StripeService{
    use ConsumesExternalServices;

    protected $key;

    protected $secret;

    protected $baseUri;



    public function __construct(){
                            //archivo services y traigo valores stripe
        $this->baseUri = config('services.stripe.base_uri');
        $this->key = config('services.stripe.key');
        $this->secret = config('services.stripe.secret');
    }

    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $headers['Authorization'] = $this->resolveAccessToken();
    }

    public function decodeResponse($response)
    {
        return json_decode($response);
    }

    public function resolveAccessToken()
    {
        return "Bearer {$this->secret}";
    }

    public function handlePayment(Request $request)
    {
        $request->validate([ //utilizo validate  para validar recibir id token de stripe
            'payment_method' => 'required',
        ]);

        $intent =  $this->createIntent($request->value,$request->currency,$request->payment_method);//creo un inteent donde recibo los valores
        //y  mando a aprovar

        session()->put('paymentIntentId',$intent->id); //pongo el id o token en  session para usarlo en handleaprovval -- id es el id que recibe de la respuesta de stripe

        return redirect()->route('approval');

    }

    public function handleApproval()
    {
        if(session()->has('paymentIntentId')){ //si  se cuentra  paymentIntentId en la sesion
            $paymentIntentId = session()->get('paymentIntentId');
            $confirmation = $this->confirmPayment($paymentIntentId);  //mando llamar confirm payment y lo guardo estado en variable, si es true o falso

            if ($confirmation->status === 'requires_action') { //si status es igual a requires_action , solo ´para tarjetas 3d secure que lo requieren

                $clientSecret = $confirmation->client_secret; //extraigo el client_secret

                return view('stripe.3d-secure')->with([ //mando a la vista 3d-secure
                    'clientSecret' => $clientSecret, //mando el client_secret
                ]);
            }

            if($confirmation->status ==='succeeded'){ //si fue succeeded y extraigo los datos desde la  estructura confirmation
                //}}$name = $confirmation->charges->data[0]->billing_details->name;
                $currency = strtoupper($confirmation->currency);
                $amount = $confirmation->amount / $this->resolveFactor($currency);

                return redirect()
                    ->route('home')
                    ->withSuccess(['payment' => "Thanks. We received your {$amount}{$currency} payment."]);
            }
        }

        return redirect()
        ->route('home')
        ->withErrors('we  were unable to confirm your payment, try again, please');
    }

    public function createIntent($value,$currency,$paymentMethod)
    {
        return $this->makeRequest(
            'POST',
            '/v1/payment_intents',
            [],
            [
                'amount' => round($value * $this->resolveFactor($currency)), //redondea y  checa si moneda acepta decimales
                'currency' => strtolower($currency), //siempre en minusculas
                'payment_method' => $paymentMethod,
                'confirmation_method' => 'manual',
            ],
        );
    }

    public function confirmPayment($paymentIntentId) //confrima pago
    {
        return $this->makeRequest(
            'POST',
            "/v1/payment_intents/{$paymentIntentId}/confirm", //url para confirmar
            [],
            [
                'return_url' => 'https://pagos.test/approval', //url de retorno
                'use_stripe_sdk' => json_encode(true), //utiliza sdk de stripe
            ]
        );
    }

    public function resolveFactor($currency){
        //aqui van los que  no soportan decimales
        $zeroDecimalCurrencies = ['JPY'];
        if(in_array(strtoupper($currency),$zeroDecimalCurrencies)){  //si currency esta en el array $zeroDecimalCurrencies
            return 1;
        }

        return 100;
    }


}
