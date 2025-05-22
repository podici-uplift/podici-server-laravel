<?php

namespace App\Logics;

class BlacklistedNames
{
    public function __construct(
        protected string $name
    ) {
        //
    }

    public function isABlacklistedUsername(): bool
    {
        return $this->isBlacklisted($this->usernames());
    }

    public function isBlacklistedShopname(): bool
    {
        return $this->isBlacklisted($this->shopnames());
    }

    public static function general(): array
    {
        return [
            'admin',
            'demo',
            'official',
            'root',
            'sudo',
            'test',
        ];
    }

    public static function usernames(): array
    {
        return array_merge(self::general(), [
            //
        ]);
    }

    public static function shopnames(): array
    {
        return array_merge(self::general(), [
            //
        ]);
    }

    private function isBlacklisted(array $blacklist): bool
    {
        return collect($blacklist)->filter(function ($name) {
            return strtolower($name) === strtolower($this->name);
        })->isNotEmpty();
    }
}
