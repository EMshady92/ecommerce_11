<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\ProductsCollection;

use App\Mail\OrderCreated;

use App\Models\Currency;

use App\Models\PaymentPlatform;

use Session;

use Inertia\Inertia;


use Illuminate\Support\Facades\Auth;

class ShoppingCartController extends Controller
{
    //
    public function __construct(){
      $this->middleware('shopping_cart');
    }

    public function show(Request $request){


        $currencies = Currency::all();
        $paymentPlatforms = PaymentPlatform::all();
        $name_user = Auth::user()->name;
        $email_user = Auth::user()->email;

        return Inertia::render('Products/ProductsShoppingCartComponent', [
            'shopping_cart_id' => $request->shopping_cart->id,
            'currencies' => $currencies,
            'paymentPlatforms' => $paymentPlatforms,
            'csrfToken' => csrf_token(),
            'keyStripe' => config('services.stripe.key'),
            'name_user'=>$name_user,
            'email_user'=>$email_user,
        ]);
    }

    public function products(Request $request){
      return new ProductsCollection($request->shopping_cart->products()->get());
    }


    public function destroy()
    {
        //
        Session::remove('shopping_cart_id');
    }
}
