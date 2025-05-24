<?php

use App\Events\ShopCreated;
use App\Events\UserActivity;
use App\Logics\ShopName;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Tests\Datasets\ShopNameUpdateDatasets;
use Tests\Helpers\Enums\HttpEndpoints;

it('requires auth to create shop', function () {
    HttpEndpoints::SELF_SHOP_CREATE->tester()->send([
        'name' => fake()->company(),
        'is_adult_shop' => fake()->boolean(),
    ])->expectAuthenticationError();
});

it('can create non adult shop shop', function () {
    Event::fake();

    $user = User::factory()->create();

    $name = fake()->company();

    $isAdultShop = false;

    HttpEndpoints::SELF_SHOP_CREATE->tester()->sendAs($user, [
        'name' => $name,
        'is_adult_shop' => $isAdultShop,
    ])->expectResource()->expectAll([
        'resource.name' => $name,
        'resource.slug' => ShopName::toSlug($name),
        'resource.is_adult_shop' => $isAdultShop,
    ]);

    Event::assertDispatched(ShopCreated::class);
    Event::assertDispatched(UserActivity::class);

    $this->assertDatabaseCount('shops', 1);
    $this->assertDatabaseHas('shops', [
        'user_id' => $user->id,
        'name' => $name,
    ]);
});

it('prevents shop name duplication', function () {
    Event::fake();

    $user = User::factory()->create();

    $existingShop = Shop::factory()->create();

    HttpEndpoints::SELF_SHOP_CREATE->tester()->sendAs($user, [
        'name' => $existingShop->name,
        'is_adult_shop' => fake()->boolean(),
    ])->expectValidationError(['name']);

    Event::assertNotDispatched(ShopCreated::class);
    Event::assertNotDispatched(UserActivity::class);

    $this->assertDatabaseCount('shops', 1);
    $this->assertDatabaseMissing('shops', [
        'user_id' => $user->id,
    ]);
});

it('prevents blacklisted shop names', function (string $blacklistedName) {
    Event::fake();

    $user = User::factory()->create();

    HttpEndpoints::SELF_SHOP_CREATE->tester()->sendAs($user, [
        'name' => str($blacklistedName)->title(),
        'is_adult_shop' => fake()->boolean(),
    ])->expectValidationError(['name']);

    Event::assertNotDispatched(ShopCreated::class);
    Event::assertNotDispatched(UserActivity::class);

    $this->assertDatabaseCount('shops', 0);
    $this->assertDatabaseMissing('shops', [
        'user_id' => $user->id,
    ]);
})->with(ShopNameUpdateDatasets::blacklistedShopnames());

it("Prevents underaged users from creating adult shop", function () {
    Event::fake();

    Config::set('settings.adult_age', 18);

    $user = User::factory()->create([
        'dob' => now()->subYears(fake()->numberBetween(1, 17))
    ]);

    HttpEndpoints::SELF_SHOP_CREATE->tester()->sendAs($user, [
        'name' => fake()->company(),
        'is_adult_shop' => true,
    ])->expectValidationError(['is_adult_shop']);

    Event::assertNotDispatched(ShopCreated::class);
    Event::assertNotDispatched(UserActivity::class);

    $this->assertDatabaseCount('shops', 0);
    $this->assertDatabaseMissing('shops', [
        'user_id' => $user->id,
    ]);
});

it("Allows underaged users to create adult shops when feature is disabled", function () {
    Event::fake();

    Config::set('settings.adult_age', 0);

    $user = User::factory()->create([
        'dob' => now()->subYears(fake()->numberBetween(1, 17))
    ]);

    $name = fake()->company();

    $isAdultShop = true;

    HttpEndpoints::SELF_SHOP_CREATE->tester()->sendAs($user, [
        'name' => $name,
        'is_adult_shop' => $isAdultShop,
    ])->expectResource()->expectAll([
        'resource.name' => $name,
        'resource.slug' => ShopName::toSlug($name),
        'resource.is_adult_shop' => $isAdultShop,
    ]);

    Event::assertDispatched(ShopCreated::class);
    Event::assertDispatched(UserActivity::class);

    $this->assertDatabaseCount('shops', 1);
    $this->assertDatabaseHas('shops', [
        'user_id' => $user->id,
        'name' => $name,
    ]);
});

it("Prevents users with no age from creating adult shop", function () {
    Event::fake();

    Config::set('settings.adult_age', 18);

    $user = User::factory()->create([
        'dob' => null
    ]);

    HttpEndpoints::SELF_SHOP_CREATE->tester()->sendAs($user, [
        'name' => fake()->company(),
        'is_adult_shop' => true,
    ])->expectValidationError(['is_adult_shop']);

    Event::assertNotDispatched(ShopCreated::class);
    Event::assertNotDispatched(UserActivity::class);

    $this->assertDatabaseCount('shops', 0);
    $this->assertDatabaseMissing('shops', [
        'user_id' => $user->id,
    ]);
});
