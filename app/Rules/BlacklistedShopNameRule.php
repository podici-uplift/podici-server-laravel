<?php

namespace App\Rules;

use App\Logics\BlacklistedNames;
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
        $blacklistedNames = new BlacklistedNames($value);

        if ($blacklistedNames->isBlacklistedShopname()) {
            $fail('validation.shop_name_prohibited')->translate();
        }
    }
}
