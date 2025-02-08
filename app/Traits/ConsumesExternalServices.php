<?php

namespace App\Traits;

use GuzzleHttp\Client;

trait ConsumesExternalServices{
    //enviar peticion y  posibles parametros , metodo, url , query que va despues del ? en  urls,  form params curpo, cabeceras, si  es json o no
    public function makeRequest($method, $requestUrl, $queryParams = [], $formParams = [], $headers = [], $isJsonRequest = false)
    {
        //clientId
        //clientSecret
        //return $this->clientSecret;
        //peticion
        $client = new Client([
            'base_uri' => $this->baseUri,
        ]);

        //validamos si  existe metodo resolveAutorization
        if (method_exists($this, 'resolveAuthorization')) {
             //autorizacion  de  peticiones y utilizarlas depende del servicio
            $this->resolveAuthorization($queryParams, $formParams, $headers);
        }


        //respuesta
        $response = $client->request($method, $requestUrl, [
            $isJsonRequest ? 'json' : 'form_params' => $formParams, // si es json mantiene json, si no, usa el cuerpo de formparams
            'headers' => $headers,
            'query' => $queryParams,
        ]);

        //contenidos , con getbody obtenemos la respuesta y luego obtenemos conteneido
        $response = $response->getBody()->getContents(); //

        if (method_exists($this, 'decodeResponse')) {
             //conversion de respuesta, dedpende del servicio
            $response = $this->decodeResponse($response);
        }

/*
        if(method_exists($this,'decodeResponse')){

        $response = $this->decodeResponse($response);
        }


         $response = $response->getBody()->getContents(); */

        return $response;
    }
}
