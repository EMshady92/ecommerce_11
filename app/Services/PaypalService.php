<?php

namespace App\Services;

use Illuminate\Http\Request;

use App\Traits\ConsumesExternalServices;

class PayPalService{
    use ConsumesExternalServices;

    protected $baseUri;

    protected $clientId;

    protected $clientSecret;

    public function __construct(){
                            //archivo services y traigo valores paypal
        $this->baseUri = config('services.paypal.base_uri');
        $this->clientId = config('services.paypal.client_id');
        $this->clientSecret = config('services.paypal.client_secret');
    }

    //los valores que llegan aqui llegan por referencia y lo que llegue se refelja en estas mismas variables usando &
    public function  resolveAuthorization(&$queryParams,&$formParams,&$headers){
        $headers['Authorization'] = $this->resolveAccessToken();
    }

    public function decodeResponse($response)
    {
        return json_decode($response);
    }

    public function resolveAccessToken()
    {  //codificamos usuairo y contraseña en baase64
        $credentials = base64_encode("{$this->clientId}:{$this->clientSecret}");

        return "Basic {$credentials}";
    }

    public function handlePayment(Request $request){

        $order = $this->createOrder($request->value,$request->currency); //mando llamar  create order
        $orderLinks = collect($order->links); //buscar links

        $approve =  $orderLinks->where('rel','approve')->first(); //obtiene rel y approve de la respuesta de paypal , provar con tinker si hay duda

        session()->put('approvalId',$order->id);
        return redirect($approve->href);
    }

    public function handleApproval(){
        if(session()->has('approvalId')){
            $approvalId = session()->get('approvalId'); //busco id
            //llamo metodo capturar pago
            $payment = $this->capturePayment($approvalId);

            //recorre approval respuesta y y  recorre y obtiene valores name , payment, currency, amount,  que estan dentro de ella
            $name = $payment->payer->name->given_name;
            $payment = $payment->purchase_units[0]->payments->captures[0]->amount;
            $amount = $payment->value;
            $currency = $payment->currency_code;

            return redirect()
            ->route('home')
           ->withSuccess(['payment'=>"thanks,{$name}. we received your {$amount}{$currency} payment."]);
        }

        return redirect()
        ->route('home')
        ->withErrors('no se puede capturar pago');

    }

    public function createOrder($value,$currency){

        return $this->makeRequest(
            'POST',
            '/v2/checkout/orders',
            [],
            [
                "intent"=> "CAPTURE",
                "purchase_units" => [
                    0 => [
                        "amount" =>  [
                            "currency_code" => strtoupper($currency),
                            "value" => round($value * $factor = $this->resolveFactor($currency)) / $factor, //con  decimales y no decimales y redondea y mando llavar resollver facttor
                        ]
                    ]
                ],
                "application_context" => [
                    "brand_name" => config('app.name'),
                    "shipping_preference" => 'NO_SHIPPING',
                    "user_action" => 'PAY_NOW',
                    "return_url" => route('approval'),
                    "cancel_url" => route('cancelled'),
                ]
            ],
            [],
            $isJsonRequest = true,
        );
    }

    public function capturePayment($approvalId){
        return $this->makeRequest(
            'POST',
            "/v2/checkout/orders/{$approvalId}/capture",
            [],
            [],
            [
                'Content-Type' =>  'application/json',
            ],
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
