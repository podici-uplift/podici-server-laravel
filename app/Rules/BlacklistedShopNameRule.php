<?php

namespace App\Rules;

use App\Logics\BlacklistedNames\BlacklistedShopNames;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BlacklistedShopNameRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (BlacklistedShopNames::isBlacklisted($value)) {
            $fail('validation.shop_name_prohibited')->translate();
        }
    }
}
