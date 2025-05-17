<?php

use App\Models\Category;
use App\Models\Shop;

test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('Can get category Shops', function () {
    $category = Category::factory()->create();

    $shop = Shop::factory()->create();

    $shop->categories()->attach($category->id);

    $this->assertDatabaseHas('categorizables', [
        'category_id' => $category->id,
        'categorizable_id' => $shop->id,
        'categorizable_type' => $shop->getMorphClass(),
    ]);

    expect($category->shops->count())->toBe(1);
});
