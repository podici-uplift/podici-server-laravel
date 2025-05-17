<?php

namespace App\Enums;

enum Currency: string
{
    case NAIRA = 'ngn';

    public function country(): Country
    {
        return match ($this) {
            self::NAIRA => Country::NIGERIA
        };
    }

    public function toString(): string
    {
        return match ($this) {
            self::NAIRA => 'Naira'
        };
    }
}
