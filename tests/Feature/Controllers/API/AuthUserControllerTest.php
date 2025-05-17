<?php

use App\Events\ProfileUpdated;
use App\Events\UserActivity;
use App\Events\UsernameSetup;
use App\Models\User;
use Illuminate\Support\Facades\Event;

describe("Get Profile", function () {
    it("Requires authentication", function () {
        httpTester("GET", "api.auth.user.profile.get")->send()
            ->expectAuthenticationError();
    });

    it("Gets correct profile", function () {
        $user = User::factory()->create();

        httpTester("GET", "api.auth.user.profile.get")->sendAs($user)
            ->expectResource()
            ->expectAll([
                'resource.id' => $user->id,
                'resource.username' => $user->username,
            ]);
    });
});

describe("Update Profile", function () {
    $baseTester = fn() => httpTester('PUT', 'api.auth.user.profile.update');

    it("Requires auth", function () use ($baseTester) {
        $baseTester()->send()->expectAuthenticationError();
    });

    it("Requires at least on field", function () use ($baseTester) {
        $user = User::factory()->create();

        $baseTester()->sendAs($user, [])->expectValidationError();
    });

    it("Validates payloads individualy", function (string $field, string $value) use ($baseTester) {
        $user = User::factory()->create();

        $baseTester()->sendAs($user, [
            $field => $value
        ])->expectValidationError([$field]);
    })->with("profile-update-form-errors");

    it("Validates payloads with damaged fields", function (string $field, string $value) use ($baseTester) {
        $user = User::factory()->create();

        $payload = httpPayload()->profileUpdate()->mod($field, $value)->data();

        $baseTester()->sendAs($user, $payload)->expectValidationError([$field]);
    })->with("profile-update-form-errors");

    it("Profile Can update", function () use ($baseTester) {
        Event::fake();

        $user = User::factory()->create();

        $payload = httpPayload()->profileUpdate()->data();

        $baseTester()->sendAs($user, $payload)->expectOk('response.action.success');

        Event::assertDispatched(ProfileUpdated::class);

        Event::assertDispatched(UserActivity::class);

        $user->refresh();

        testCase($this)->assertSame($payload, [
            'phone' => $user->phone,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'other_names' => $user->other_names,
            'gender' => $user->gender,
            'bio' => $user->bio,
        ]);
    });
});

describe("Update Password", function () {

});

describe("Update username", function () {
    $baseTester = fn() => httpTester('POST', 'api.auth.user.profile.username.update');

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
