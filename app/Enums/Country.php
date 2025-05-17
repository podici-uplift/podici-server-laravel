<?php

namespace App\Enums;

use App\Logic\KYCRules;

enum Country: string
{
    case NIGERIA = 'ng';

    public function currency(): Currency
    {
        return match ($this) {
            self::NIGERIA => Currency::NAIRA
        };
    }

    public function phoneNumberPattern(): string
    {
        return match ($this) {
            self::NIGERIA => "/^(234)([7-9][0-1])([0-9]{8})$/"
        };
    }

    public function toString(): string
    {
        return match ($this) {
            self::NIGERIA => 'Nigeria'
        };
    }

    public function phoneIsValid(string $phone): bool
    {
        $pattern = $this->phoneNumberPattern();

        return str($phone)->test($pattern);
    }
}
