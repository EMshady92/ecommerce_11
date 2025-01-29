<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    use HasFactory;
    public function approve(){
        $this->updateCustomIDAndStatus();
      }

      public function generateCustomID(){

        return md5("$this-id $this->updated_at"); //concateno id y fecha


      }

      public function updateCustomIDAndStatus(){
          $this->status = "approved";
          $this->customid = $this->generateCustomID();
          $this->save();

      }
      //
      public static function findOrCreateById($shopping_cart_id){
        //resibe un ID
        if($shopping_cart_id){ // si el id es un valor numerico verdadero
          return ShoppingCart::find($shopping_cart_id); //busca un carrito con ese id
        }else{ //si no
          return ShoppingCart::create(); //crea un carrito de compras nuevo
        }
      }

    //obtener todos los productos
    public function products(){
     return $this->belongsToMany('App\Models\Product','product_in_shopping_carts');
                                  //nombre del modelo a extraer registro , nombre de la tabla que relaciona en BD
      }

      public function productsCount(){
      return $this->products()->count();
              //resultado de la funciion products() y count cuenta los elemtnos del producto
      }

      public function amount(){
        return $this->products()->sum("price") / 100;
      }

      public function amountInCents(){
        return $this->products()->sum("price");
      }
}
