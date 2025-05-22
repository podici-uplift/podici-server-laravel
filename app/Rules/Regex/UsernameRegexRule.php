<?php

namespace App\Rules\Regex;

class UsernameRegexRule extends RegexRule
{
    public function __construct()
    {
        parent::__construct(
            '/^[a-z][a-z0-9]*[\.\_]?[a-z0-9\_]+$/i',
            'validation.username_invalid'
        );
    }
}
