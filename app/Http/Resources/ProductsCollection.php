<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request) //en este metodo convertimos la informacion que se envia
                                      // de tipo json a una falsa por seguridad
    {
        return [
          'data' => $this->collection->transform(function($element){
            return [
              'title' => $element->title,
              'id' => $element->id,
              'humanPrice' => "$".(number_format($element->price,2)), //precio /100 y con el signo dde pesos
              'numberPrice' => $element->price,
              'image' => $element->image_url,
              'description' => $element->description
            ];
          })
        ];
    }
}
