<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PayPalService;
use  App\Resolvers\PaymentPlatformResolver;
class PaymentController extends Controller
{

    protected $paymentPlatformResolver; //para verificar cual metodo de pago selecciono el  usuairo, manda llamar PaymentPlatformResolver que recibe tipo de pago

    public function __construct(PaymentPlatformResolver $paymentPlatformResolver){
        $this->middleware('auth');
        $this->paymentPlatformResolver = $paymentPlatformResolver;
    }

    public function pay(Request $request){

        $rules  = [
            'value' => ['required','numeric','min:5'],
            'currency' => ['required','exists:currencies,iso'],
            'payment_platform' => ['required','exists:payment_platforms,id'],
        ];

        $request->validate($rules);

        $paymentPlatform = $this->paymentPlatformResolver
        ->resolveService($request->payment_platform);

        session()->put('paymentPlatformId', $request->payment_platform); //agregamos a la  session el id que esta en request ppara usarlo en approval
        session()->put('shopping_cart_id', $request->shopping_cart_id);
        return $paymentPlatform->handlePayment($request);
    }
    //cuando ya se aprobo el pago llega aqui
    public function approval(){

        if(session()->has('paymentPlatformId')){
            $paymentPlatform = $this->paymentPlatformResolver
            ->resolveService(session()->get('paymentPlatformId'));

            return $paymentPlatform->handleApproval(session()->get('shopping_cart_id'));
        }


    return redirect()
            ->route('home')
        ->withErrors('we cannot retrieve your payment Platform, Try again');
    }

    public function cancelled(){
         return redirect()
        ->route('home')
        ->withErrors('no se puede capturar pago');
    }
}
