<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\ShoppingCart;
use App\Http\Resources\ProductsCollection;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ProductController extends Controller
{
    public function index(Request $request)
    {



        $products = Product::get();

        /* $sessionName = 'shopping_cart_id';
        $shopping_cart_id = $request->session()->get($sessionName);

        $shopping_cart =  ShoppingCart::findOrCreateById($shopping_cart_id);

        $request->session()->put($sessionName, $shopping_cart->id); */

                  return Inertia::render('Products/index', [
                    'products' => $products,
                ]);



        //return view("products.index");
        /*$products = Product::paginate(15);  //traigo todos los productos

        if($request->wantsJson()){ //devuelve falso o verdadero
          return new ProductsCollection($products); //si devuelve verdadero regresa info en tipo json
        } */




        //return view('products.index',['products' => $products]); //mando los productos en
        //una variable $products a la vista

    }
}
