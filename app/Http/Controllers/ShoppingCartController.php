<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\ProductsCollection;

use App\Mail\OrderCreated;

use App\Models\Currency;

use App\Models\PaymentPlatform;

use Session;

use Inertia\Inertia;

class ShoppingCartController extends Controller
{
    //
    public function __construct(){
      $this->middleware('shopping_cart');
    }

    public function show(Request $request){


        $currencies = Currency::all();
        $paymentPlatforms = PaymentPlatform::all();


        return Inertia::render('Products/ProductsShoppingCartComponent', [
            'shopping_cart' => $request->shopping_cart,
            'currencies' => $currencies,
            'paymentPlatforms' => $paymentPlatforms,
            'csrfToken' => csrf_token(),
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
