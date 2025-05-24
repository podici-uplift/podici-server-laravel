<?php

use App\Events\UserActivity;
use App\Events\UsernameSetup;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Tests\Datasets\UsernameUpdateDatasets;
use Tests\Helpers\Enums\HttpEndpoints;

describe("UPDATE USERNAME SUCCESS CASES ✅", function () {
    it("Doesn't update when recently updated", function () {
        $cooldown = fake()->numberBetween(1, 100);
        Config::set('settings.user.username_update_cooldown', $cooldown);

        $user = createUser();

        $newUsername = uniqid('user');

        $user->recordFieldUpdate('username');

        updateUsernameAs($user, $newUsername)->expectUnauthorized();

        assertUsernameNotUpdated();

        $this->travel($cooldown)->days();

        updateUsernameAs($user, $newUsername)->expectOk('response.action.success');

        assertUsernameUpdated($user, $newUsername);
    });

    it('Updates', function ($validUsername) {
        $user = createUser();

        updateUsernameAs($user, $validUsername)->expectOk('response.action.success');

        assertUsernameUpdated($user, $validUsername);
    })->with(UsernameUpdateDatasets::validUsernames());
});

describe('UPDATE USERNAME FAIL CASES ❌', function () {
    it('Requires auth', function () {
        HttpEndpoints::SELF_USERNAME_UPDATE->tester()->send()->expectAuthenticationError();
    });

    it('Requires unique usernames', function () {
        $userOne = createUser();
        $userTwo = createUser();

        updateUsernameAs($userOne, $userTwo->username)
            ->expectValidationError(['username']);

        assertUsernameNotUpdated();
    });

    it('Validates username', function ($invalidUsername) {
        $user = userFactory()->noUsername()->create();

        updateUsernameAs($user, $invalidUsername)->expectValidationError(['username']);

        assertUsernameNotUpdated();
    })->with(UsernameUpdateDatasets::invalidUsernames());
});

function updateUsernameAs(User $user, string $username)
{
    return HttpEndpoints::SELF_USERNAME_UPDATE->tester()->sendAs($user, ['username' => $username]);
}

function assertUsernameNotUpdated()
{
    Event::assertNotDispatched(UsernameSetup::class);
    Event::assertNotDispatched(UserActivity::class);
}

function assertUsernameUpdated(User $user, string $newUsername)
{
    Event::assertDispatched(UsernameSetup::class);
    Event::assertDispatched(UserActivity::class);

    $user->refresh();
    expect($user->username)->toBe($newUsername);
}
