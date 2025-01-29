<?php

namespace App\Http\Middleware;

use Closure;

use App\Models\ShoppingCart;

class SetShoppingCart
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      $sessionName = 'shopping_cart_id'; //extraigo el id de shopping_cart_id

      $shopping_cart_id = \Session::get($sessionName);
      //extraigo session con el id
      // si esto retorna un Null retona a ShoppingCart.php y crea el carrito de compras


     $shopping_cart =  ShoppingCart::findOrCreateById($shopping_cart_id);
      //obtenemos el carrito de compras con el metodo                                                                       //findOrCreateById donde pasmams el id que obtuvimos de las sesiones


      //la variable $shopping_cart no se envia al controlador
     $request->shopping_cart = $shopping_cart;
     //agregamos un atributo para request tipo shopping_cart

    //guardamos o actualzar la session del carrito que encontramos o creamos
    \Session::put($sessionName, $shopping_cart ->id);

        return $next($request);
    }
}
