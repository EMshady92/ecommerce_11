<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ProductInShoppingCart;

class ProductInShoppingCartsController extends Controller
{


   public function __construct(){
     $this->middleware("shopping_cart");
    }
    //
    public function store(Request $request){
      //$request->shopping_cart; // le damos la propiedad shopping_cart a $request

      $in_shopping_cart = ProductInShoppingCart::create([
      //regustro que guarde la referencia que un producto esta en el carrito
      //creamos nuevo registro
      //usamos la tabla de  muchos a muchos ProductInShoppingCart
      'shopping_cart_id' => $request->shopping_cart->id,
      'product_id' => $request->product_id
    ]);


      //si todo salio bien redireccionamos a
      if($in_shopping_cart){
         return redirect()->back(); //hacia la pagina donde provenia
       } //si no...
         return redirect()->back()->withErrors(['product' => 'No se pudo agregar el producto']);
     }

     public function destroy(Request $id){}
}
