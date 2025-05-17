<?php

namespace App\Rules\Regex;

use App\Enums\Country;

class PhoneNumber extends RegexRule
{
    public function __construct(Country $country)
    {
        parent::__construct($country->phoneNumberPattern(), 'validation.phone_invalid');
    }
}
