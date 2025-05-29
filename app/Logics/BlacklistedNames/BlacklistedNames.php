<?php

namespace App\Logics\BlacklistedNames;

abstract class BlacklistedNames
{
    public static function blacklist(): array
    {
        return array_merge(self::general(), self::blacklistedNames());
    }

    public static function isBlacklisted(string $name): bool
    {
        $blacklist = self::blacklist();

        return collect($blacklist)->filter(function ($blacklistedName) use ($name) {
            return strtolower($blacklistedName) === strtolower($name);
        })->isNotEmpty();
    }

    abstract protected static function blacklistedNames(): array;

    private static function general(): array
    {
        return ['admin', 'demo', 'official', 'root', 'sudo', 'test',];
    }
}
