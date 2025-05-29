<?php

namespace App\Rules;

use App\Models\Shop;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueShopNameRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (Shop::nameUsed($value)) {
            $fail('validation.shop_name_in_use')->translate();
        }
    }
}
