<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // lo exportamos para usar View
use App\Models\ShoppingCart;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        View::composer('*',function($view){ // cuando se muestre cualquier vista(en todas) '*'
            // ejecuta el proceso del carrito


        // Funcionara en todas las views

        $sessionName = 'shopping_cart_id'; //extraigo el id de shopping_cart_id

        $shopping_cart_id = \Session::get($sessionName);
        //extraigo session con el id
        // si esto retorna un Null retona a ShoppingCart.php y crea el carrito de compras


        $shopping_cart =  ShoppingCart::findOrCreateById($shopping_cart_id); //obtenemos el carrito de compras con el metodo
                                                        //findOrCreateById donde pasmams el id que obtuvimos de las sesiones

        //guardamos o actualzar la session del carrito que encontramos o creamos

        \Session::put($sessionName, $shopping_cart->id); //queremos guardar la session en $sessionName y lo que queremos guardar ($shopping_cart->id)

        //session($sessionName); //extrae la session
        //$request->session()->get($sessionName); //extrae sesison , cualquiera de las dos es valida
        //-\Session::get($sessionName); //al igal que esta es valida para obtener la sesion.
        $view->with('productsCount',$shopping_cart->productsCount());

});
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
