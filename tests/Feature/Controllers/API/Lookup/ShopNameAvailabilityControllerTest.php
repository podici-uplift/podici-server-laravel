<?php

use App\Models\Shop;
use Tests\Helpers\Enums\HttpEndpoints;

it('can check shop name availability', function () {
    $shop = Shop::factory()->create();

    HttpEndpoints::LOOKUP_SHOP_NAME_AVAILABILITY->tester()->send(['name' => $shop->name])
        ->expectOk('response.action.success')
        ->expectAll([
            'data.is_available' => false,
            'data.slug' => $shop->slug,
        ]);

    $otherName = str(fake()->company())->limit(Shop::nameLengthLimit(), end: '');

    HttpEndpoints::LOOKUP_SHOP_NAME_AVAILABILITY->tester()->send(['name' => $otherName])
        ->expectOk('response.action.success')
        ->expectAll([
            'data.is_available' => true,
            'data.slug' => Shop::sluggifyName($otherName),
        ]);
});
