<?php

namespace App\Services\Traits;

use Illuminate\Support\Facades\Http;

trait ConsumeExternalService
{
    public function headers(
        array $headers = [],
    ) {

        $defaultHeaders = [
            'Accept' => 'application/json',
            'Authorization' => $this->token,
        ];

        return array_merge($defaultHeaders, $headers);
    }

    /**
     * @return \Illuminate\Http\Response
     */

    public function request(
        string $method,
        string $endPoint,
        array $formParams = [],
        array $headers = []
    ) {

        return Http::withHeaders($this->headers($headers))
            ->$method($endPoint, $formParams);
    }
}
