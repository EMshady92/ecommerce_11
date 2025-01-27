<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
     //
     public $fillable = ['id','title','description','price','image_url','categoria']; //en el arreglo
     //se traen lo que se va a modificar en el formulario es una proteccion

     public function ScopeLatest($query){
       return $query->orderBy("id","desc");
     }

     public function ScopeSearch($query){
       return $query->orderBy("id","desc");
     }

     public function ScopeTitle($query,$title){
       if($title)
       return $query->Orwhere('title','LIKE',"%$title%");
     }

     public function ScopeCategoria($query,$categoria){
       if($categoria)
       return $query->Orwhere('categoria','LIKE',"%$categoria%");
     }
}
