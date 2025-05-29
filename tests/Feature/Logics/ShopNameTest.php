<?php

use App\Models\Shop;

it('Correctly gets name length limit', function () {
    expect(Shop::nameLengthLimit())->toBe(config('settings.shop.name_length_limit'));
});

it('Converts to slug correctly', function ($name, $expected) {
    expect(Shop::sluggifyName($name))->toBe($expected);
})->with([
    ['name' => 'Test Shop', 'expected' => 'test-shop'],
    ['name' => 'Test Shop 2', 'expected' => 'test-shop-2'],
    ['name' => 'Test Shop 3', 'expected' => 'test-shop-3'],
    ['name' => 'Test Shop@', 'expected' => 'test-shop-at'],
    ['name' => 'Test Shop1@2', 'expected' => 'test-shop1-at-2'],
    ['name' => 'Test Shop#', 'expected' => 'test-shop'],
    ['name' => 'Test Shop1#2', 'expected' => 'test-shop12'],
]);

it('Checks availability correctly', function () {
    $shop = Shop::factory()->create();

    expect(Shop::nameUsed('Test Shop'))->toBeFalse();
    expect(Shop::nameUsed($shop->name))->toBeTrue();
})->repeat(10);
