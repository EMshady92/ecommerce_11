<?php

namespace App\Services;

use App\Traits\ConsumesExternalServices;

class CurrencyConversionService
{
    use ConsumesExternalServices;

    protected $baseUri;

    protected $apiKey;

    public function __construct()
    {
        $this->baseUri = config('services.currency_conversion.base_uri');
        $this->apiKey = config('services.currency_conversion.api_key');
    }

    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $queryParams['apiKey'] = $this->resolveAccessToken(); //ejecuta resolveAccessToken y manda queryparams a la posicion apiKey
    }

    public function decodeResponse($response)
    {
        return json_decode($response);
    }

    public function resolveAccessToken()
    {
        return $this->apiKey;
    }

    public function convertCurrency($from, $to)
    {

        $response = $this->makeRequest(
            'GET',
            '/v6/'.$this->apiKey.'/pair/'.$from.'/'.$to.'/', //checar esto
            [
                /* 'q' => "{$from}_{$to}",
                'compact' => 'ultra', */
            ],
        );

        //return $response->{strtoupper("{$from}_{$to}")};
        return $response->conversion_rate;
    }

}
