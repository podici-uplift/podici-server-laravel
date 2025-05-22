<?php

namespace App\Rules\Regex;

class LegalNameRegexRule extends RegexRule
{
    public function __construct(
        bool $allowSpace = false
    ) {
        $pattern = $allowSpace
            ? '/^[A-Za-z]{3,64}(\s[A-Za-z]{3,64}){0,3}$/'
            : '/^[A-Za-z][A-Za-z\'-]{1,24}$/';

        parent::__construct($pattern, 'validation.legal_name_invalid');
    }
}
