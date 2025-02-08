<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
use App\Models\ShoppingCart;


class MainController extends Controller
{
    public function home(Request $request){
        $title = $request->get('title');

        $products = Product::all();

        $sessionName = 'shopping_cart_id';
        $shopping_cart_id = \Session::get($sessionName);
        $shopping_cart = ShoppingCart::findOrCreateById($shopping_cart_id);
        \Session::put($sessionName, $shopping_cart->id);
        $productsCount = $shopping_cart->products()->count();

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'products' => $products,
            'productsCount' => $productsCount,
        ]);
    }
}
