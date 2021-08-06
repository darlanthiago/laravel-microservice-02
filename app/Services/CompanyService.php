<?php

namespace App\Services;

use App\Services\Traits\ConsumeExternalService;

class CompanyService
{
    use ConsumeExternalService;

    protected $url;
    protected $token;

    public function __construct()
    {
        $this->url = config('services.micro_01.url');
        $this->token = config('services.micro_01.token');
    }

    public function getCompany(string $company)
    {

        $endPoint = $this->url . "/companies/{$company}";

        $method = 'get';

        $response = $this->request($method, $endPoint);

        return $response;
    }
}
