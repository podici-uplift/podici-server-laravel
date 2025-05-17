<?php

namespace App\Rules\Regex;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

abstract class RegexRule implements ValidationRule
{
    public function __construct(
        protected readonly string $pattern,
        protected readonly string $failMessage,
    ) {
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! str($value)->test($this->pattern)) {
            $fail($this->failMessage)->translate();
        }
    }
}
