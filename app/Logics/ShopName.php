<?php

namespace App\Logics;

use App\Models\Shop;

class ShopName
{
    public static function nameLengthLimit(): int
    {
        return config('settings.shop.name_length_limit');
    }

    public static function toSlug(string $name): string
    {
        $limit = self::nameLengthLimit();

        return str($name)->limit($limit, end: '')->slug();
    }

    public static function isAvailable(string $name): bool
    {
        return ! self::isInUse($name);
    }

    public static function isInUse(string $name): bool
    {
        $slug = self::toSlug($name);

        return Shop::where('slug', $slug)->exists();
    }
}
