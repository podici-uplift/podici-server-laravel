<?php

namespace Tests\Helpers\Enums;

use Illuminate\Support\Collection;
use Tests\Helpers\HttpTester;

enum HttpEndpoints: string
{
    case SELF_PROFILE = 'GET:api.user.profile.index';
    case SELF_PROFILE_UPDATE = 'PUT:api.user.profile.update';
    case SELF_PASSWORD_UPDATE = 'POST:api.user.password-update';
    case SELF_SHOP_CREATE = 'POST:api.user.shop.create';
    case SELF_USERNAME_UPDATE = 'POST:api.user.username-update';

    public function tester(): HttpTester
    {
        return httpTester($this->method(), $this->route());
    }

    private function parameters(): Collection
    {
        return str($this->value)->split('/[:]+/');
    }

    private function method()
    {
        return $this->parameters()->first();
    }

    private function route()
    {
        return $this->parameters()->last();
    }
}
