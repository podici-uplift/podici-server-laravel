<?php

use App\Logics\ShopName;
use App\Models\Shop;

$baseTester = fn () => httpTester('POST', 'api.lookup.availability.shop-name');

it('can check shop name availability', function () use ($baseTester) {
    $shop = Shop::factory()->create();

    $baseTester()->send(['name' => $shop->name])
        ->expectOk('response.action.success')
        ->expectAll([
            'data.is_available' => false,
            'data.slug' => $shop->slug,
        ]);

    $otherName = str(fake()->company())->limit(ShopName::nameLengthLimit(), end: '');

    $baseTester()->send(['name' => $otherName])
        ->expectOk('response.action.success')
        ->expectAll([
            'data.is_available' => true,
            'data.slug' => ShopName::toSlug($otherName),
        ]);
});
