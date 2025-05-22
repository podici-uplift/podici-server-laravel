<?php

namespace App\Rules\Regex;

use App\Logics\ShopName as ShopNameLogic;
use Closure;

class ShopNameRegexRule extends RegexRule
{
    public function __construct()
    {
        parent::__construct(
            '/^[a-z].+$/i',
            'validation.shop_name_invalid'
        );
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        parent::validate($attribute, $value, $fail);

        if (strlen($value) > ShopNameLogic::nameLengthLimit()) {
            $fail('validation.shop_name_too_long')->translate();
        }
    }
}
