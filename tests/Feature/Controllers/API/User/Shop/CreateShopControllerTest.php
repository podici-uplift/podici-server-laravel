<?php

use App\Events\ShopCreated;
use App\Events\UserActivity;
use App\Logics\ShopName;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Tests\Datasets\ShopNameUpdateDatasets;
use Tests\Helpers\Enums\HttpEndpoints;

/**
 * SUCCESS CASES ✅
 */

it('can create non adult shop shop', function () {
    $user = createUser();

    $name = fake()->company();

    createShopAs($user, [
        'name' => $name,
        'is_adult_shop' => false,
    ])->expectResource()->expectAll(resourceExpectation($name, false));

    assertShopCreated($user, $name);
});

it("Allows underaged users to create adult shops when feature is disabled", function () {
    Config::set('settings.adult_age', 0);

    $user = userFactory()->youngerThan(17)->create();

    $name = fake()->company();

    createShopAs($user, [
        'name' => $name,
        'is_adult_shop' => true,
    ])->expectResource()->expectAll(resourceExpectation($name, true));

    assertShopCreated($user, $name);
});

/**
 * ERROR CASES 🔴
 */

it('requires auth to create shop', function () {
    HttpEndpoints::SELF_SHOP_CREATE->tester()->send([
        'name' => fake()->company(),
        'is_adult_shop' => fake()->boolean(),
    ])->expectAuthenticationError();
});

it('prevents shop name duplication', function () {
    $user = createUser();

    $existingShop = Shop::factory()->create();

    createShopAs($user, [
        'name' => $existingShop->name,
        'is_adult_shop' => fake()->boolean(),
    ])->expectValidationError(['name']);

    assertShopNotCreated($user, 1);
});

it('prevents blacklisted shop names', function (string $blacklistedName) {
    $user = createUser();

    createShopAs($user, [
        'name' => str($blacklistedName)->title(),
        'is_adult_shop' => fake()->boolean(),
    ])->expectValidationError(['name']);

    assertShopNotCreated($user);
})->with(ShopNameUpdateDatasets::blacklistedShopnames());

it("Prevents underaged users from creating adult shop", function () {
    Config::set('settings.adult_age', 18);

    $user = userFactory()->youngerThan(17)->create();

    createShopAs($user, [
        'name' => fake()->company(),
        'is_adult_shop' => fake()->boolean(),
    ])->expectValidationError(['is_adult_shop']);

    assertShopNotCreated($user);
});

it("Prevents users with no age from creating adult shop", function () {
    Config::set('settings.adult_age', 18);

    $user = userFactory()->noDob()->create();

    createShopAs($user, [
        'name' => fake()->company(),
        'is_adult_shop' => true,
    ])->expectValidationError(['is_adult_shop']);

    assertShopNotCreated($user);
});

/*******************************************************************************
 * Helpers
 ******************************************************************************/

function createShopAs(User $user, array $data)
{
    return HttpEndpoints::SELF_SHOP_CREATE->tester()->sendAs($user, $data);
}

function assertShopCreated(User $user, string $name, int $expectedCount = 1)
{
    Event::assertDispatched(ShopCreated::class);
    Event::assertDispatched(UserActivity::class);

    test()->assertDatabaseCount('shops', $expectedCount);
    test()->assertDatabaseHas('shops', ['user_id' => $user->id, 'name' => $name,]);
}

function assertShopNotCreated(User $user, int $expectedCount = 0)
{
    Event::assertNotDispatched(ShopCreated::class);
    Event::assertNotDispatched(UserActivity::class);

    test()->assertDatabaseCount('shops', $expectedCount);
    test()->assertDatabaseMissing('shops', ['user_id' => $user->id,]);
}

function resourceExpectation(string $name, bool $isAdult)
{
    return [
        'resource.name' => $name,
        'resource.slug' => ShopName::toSlug($name),
        'resource.is_adult_shop' => $isAdult,
    ];
}
