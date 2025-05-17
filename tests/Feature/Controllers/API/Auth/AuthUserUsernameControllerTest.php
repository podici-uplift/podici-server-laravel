<?php

use App\Events\UserActivity;
use App\Events\UsernameSetup;
use App\Models\User;

describe("Update username", function () {
    $baseTester = fn() => httpTester('POST', 'api.auth.user.username-update');

    it("Requires auth", function () use ($baseTester) {
        $baseTester()->send()->expectAuthenticationError();
    });

    it("Requires unique usernames", function () use ($baseTester) {
        $userOne = User::factory()->create([
            'username_last_updated_at' => null,
        ]);

        $userTwo = User::factory()->create([
            'username_last_updated_at' => null,
        ]);

        $baseTester()->sendAs($userOne, [
            'username' => $userTwo->username
        ])->expectValidationError(['username']);
    });

    it("Doesn't update when recently updated", function () use ($baseTester) {
        Event::fake();

        $user = User::factory()->create([
            'username_last_updated_at' => now()
        ]);

        $baseTester()->sendAs($user, [
            'username' => uniqid("user")
        ])->expectUnauthorized();

        Event::assertNotDispatched(UsernameSetup::class);

        Event::assertNotDispatched(UserActivity::class);

        $cooldownDuration = (int) config('settings.user.username_update_cooldown', 0);

        $this->travel($cooldownDuration + 1)->days();

        $newUsername = uniqid("user");

        $baseTester()->sendAs($user, [
            'username' => $newUsername
        ])->expectOk("response.action.success");

        Event::assertDispatched(UsernameSetup::class);

        Event::assertDispatched(UserActivity::class);

        $user->refresh();

        expect($user->username)->toBe($newUsername);
    });

    it("Updates with cooldown", function () use ($baseTester) {
        Event::fake();

        $user = User::factory()->create([
            'username_last_updated_at' => null
        ]);

        $newUsername = uniqid("user");

        $baseTester()->sendAs($user, [
            'username' => $newUsername
        ])->expectOk("response.action.success");

        Event::assertDispatched(UsernameSetup::class);

        Event::assertDispatched(UserActivity::class);

        $user->refresh();

        expect($user->username)->toBe($newUsername);
    });
});
