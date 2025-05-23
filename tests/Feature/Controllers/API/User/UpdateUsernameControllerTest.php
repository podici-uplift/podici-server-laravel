<?php

use App\Events\UserActivity;
use App\Events\UsernameSetup;
use App\Models\User;
use Tests\Datasets\UsernameUpdateDatasets;
use Tests\Helpers\Enums\HttpEndpoints;

describe('Update username', function () {

    it('Requires auth', function () {
        HttpEndpoints::SELF_USERNAME_UPDATE->tester()->send()->expectAuthenticationError();
    });

    it('Requires unique usernames', function () {
        $userOne = User::factory()->create([
            'username_last_updated_at' => null,
        ]);

        $userTwo = User::factory()->create([
            'username_last_updated_at' => null,
        ]);

        HttpEndpoints::SELF_USERNAME_UPDATE->tester()->sendAs($userOne, [
            'username' => $userTwo->username,
        ])->expectValidationError(['username']);
    });

    it("Doesn't update when recently updated", function () {
        Event::fake();

        $user = User::factory()->create([
            'username_last_updated_at' => now(),
        ]);

        HttpEndpoints::SELF_USERNAME_UPDATE->tester()->sendAs($user, [
            'username' => uniqid('user'),
        ])->expectUnauthorized();

        Event::assertNotDispatched(UsernameSetup::class);

        Event::assertNotDispatched(UserActivity::class);

        $cooldownDuration = (int) config('settings.user.username_update_cooldown', 0);

        $this->travel($cooldownDuration + 1)->days();

        $newUsername = uniqid('user');

        HttpEndpoints::SELF_USERNAME_UPDATE->tester()->sendAs($user, [
            'username' => $newUsername,
        ])->expectOk('response.action.success');

        Event::assertDispatched(UsernameSetup::class);

        Event::assertDispatched(UserActivity::class);

        $user->refresh();

        expect($user->username)->toBe($newUsername);
    });

    it('Updates with cooldown', function ($validUsername) {
        Event::fake();

        $user = User::factory()->create([
            'username_last_updated_at' => null,
        ]);

        HttpEndpoints::SELF_USERNAME_UPDATE->tester()->sendAs($user, [
            'username' => $validUsername,
        ])->expectOk('response.action.success');

        Event::assertDispatched(UsernameSetup::class);

        Event::assertDispatched(UserActivity::class);

        $user->refresh();

        expect($user->username)->toBe($validUsername);
    })->with(UsernameUpdateDatasets::validUsernames());

    it('Validates username', function ($invalidUsername) {
        Event::fake();

        $user = User::factory()->create([
            'username_last_updated_at' => null,
            'username' => null,
        ]);

        HttpEndpoints::SELF_USERNAME_UPDATE->tester()->sendAs($user, [
            'username' => $invalidUsername,
        ])->expectValidationError(['username']);

        Event::assertNotDispatched(UsernameSetup::class);

        Event::assertNotDispatched(UserActivity::class);

        $user->refresh();

        expect($user->username)->toBe(null);
        expect($user->username_last_updated_at)->toBe(null);
    })->with(UsernameUpdateDatasets::invalidUsernames());
});
