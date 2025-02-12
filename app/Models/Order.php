<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['name','currency','recipient_name','line1','line2','city'
    ,'country_code','state','postal_code','email'
    ,'shopping_cart_id','total','guide_number'];

    public static function createFromPayPalResponse($paypalResponse, $shoping_cart_id){


/*
            //recorre approval respuesta y y  recorre y obtiene valores name , payment, currency, amount,  que estan dentro de ella
            $name = $payment->payer->name->given_name;
            $payment = $payment->purchase_units[0]->payments->captures[0]->amount;
            $amount = $payment->value;
            $currency = $payment->currency_code;
*/

        $name = $paypalResponse->payer->name->given_name;
        $payment = $paypalResponse->purchase_units[0]->payments->captures[0]->amount;
        $amount = $paypalResponse->purchase_units[0]->payments->captures[0]->amount->value;
        $email = $paypalResponse->payer->email_address;
        $currency = $paypalResponse->purchase_units[0]->payments->captures[0]->amount->currency_code;


        $new_order = [
              'name' => $name,
              'shopping_cart_id' => intval($shoping_cart_id),
              'total' => $amount,
              'currency' => $currency,
              'email' => $email,
            ];

        return Order::create($new_order);


      }

      public static function createFromStripeResponse($stripeResponse, $shoping_cart_id){


                return Order::create($stripeResponse);


              }
}
