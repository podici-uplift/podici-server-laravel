<?php

use App\Events\PasswordUpdated;
use App\Events\UserActivity;
use App\Models\User;
use Tests\Datasets\PasswordUpdateDataSets;

describe('Update Password', function () {
    $baseTester = fn () => httpTester('POST', 'api.auth.user.password-update');

    it('Requires auth', function () use ($baseTester) {
        $baseTester()->send()->expectAuthenticationError();
    });

    it('Requires confirmation to be valid', function () use ($baseTester) {
        Event::fake();

        $user = User::factory()->create();

        $baseTester()->sendAs($user, [
            'password' => 'A valid password#',
            'password_confirmation' => 'A valid password',
        ])->expectValidationError(['password']);

        Event::assertNotDispatched(PasswordUpdated::class);

        Event::assertNotDispatched(UserActivity::class);
    });

    it('Requires a valid password', function ($invalidPassword) use ($baseTester) {
        Event::fake();

        $user = User::factory()->create();

        $baseTester()->sendAs($user, [
            'password' => $invalidPassword,
            'password_confirmation' => $invalidPassword,
        ])->expectValidationError(['password']);

        Event::assertNotDispatched(PasswordUpdated::class);

        Event::assertNotDispatched(UserActivity::class);
    })->with(PasswordUpdateDataSets::invalidPasswords());

    it('Updates correctly', function ($validPassword) use ($baseTester) {
        Event::fake();

        $user = User::factory()->create();

        $baseTester()->sendAs($user, [
            'password' => $validPassword,
            'password_confirmation' => $validPassword,
        ])->expectOk('response.action.success');

        Event::assertDispatched(PasswordUpdated::class);

        Event::assertDispatched(UserActivity::class);
    })->with(PasswordUpdateDataSets::validPasswords());
});
