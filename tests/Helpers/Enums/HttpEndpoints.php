<?php

namespace Tests\Helpers\Enums;

use Tests\Helpers\HttpTester;

enum HttpEndpoints: string
{
    case AUTH_CREATE_SHOP = "api.auth.shop.create";

    public function tester(string $method = "GET"): HttpTester
    {
        return httpTester($method, $this->value);
    }

    public function post(): HttpTester
    {
        return $this->tester("POST");
    }

    public function get(): HttpTester
    {
        return $this->tester("GET");
    }
}
