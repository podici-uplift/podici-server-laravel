<?php

use App\Events\PasswordUpdated;
use App\Events\UserActivity;
use App\Models\User;
use Tests\Datasets\PasswordUpdateDatasets;
use Tests\Helpers\Enums\HttpEndpoints;

describe('Update Password', function () {
    it('Requires auth', function () {
        HttpEndpoints::SELF_PASSWORD_UPDATE->tester()->send()->expectAuthenticationError();
    });

    it('Requires confirmation to be valid', function () {
        Event::fake();

        $user = User::factory()->create();

        HttpEndpoints::SELF_PASSWORD_UPDATE->tester()->sendAs($user, [
            'password' => 'A valid password#',
            'password_confirmation' => 'A valid password',
        ])->expectValidationError(['password']);

        Event::assertNotDispatched(PasswordUpdated::class);

        Event::assertNotDispatched(UserActivity::class);
    });

    it('Requires a valid password', function ($invalidPassword) {
        Event::fake();

        $user = User::factory()->create();

        HttpEndpoints::SELF_PASSWORD_UPDATE->tester()->sendAs($user, [
            'password' => $invalidPassword,
            'password_confirmation' => $invalidPassword,
        ])->expectValidationError(['password']);

        Event::assertNotDispatched(PasswordUpdated::class);

        Event::assertNotDispatched(UserActivity::class);
    })->with(PasswordUpdateDatasets::invalidPasswords());

    it('Updates correctly', function ($validPassword) {
        Event::fake();

        $user = User::factory()->create();

        HttpEndpoints::SELF_PASSWORD_UPDATE->tester()->sendAs($user, [
            'password' => $validPassword,
            'password_confirmation' => $validPassword,
        ])->expectOk('response.action.success');

        Event::assertDispatched(PasswordUpdated::class);

        Event::assertDispatched(UserActivity::class);
    })->with(PasswordUpdateDatasets::validPasswords());
});
