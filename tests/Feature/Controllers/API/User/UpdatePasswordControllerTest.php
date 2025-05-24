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

    it('Sets up new password correctly', function ($validPassword) {
        Event::fake();

        $user = User::factory()->create([
            'password' => null
        ]);

        HttpEndpoints::SELF_PASSWORD_UPDATE->tester()->sendAs($user, [
            'password' => $validPassword,
            'password_confirmation' => $validPassword,
        ])->expectOk('response.action.success');

        Event::assertDispatched(PasswordUpdated::class);

        Event::assertDispatched(UserActivity::class);
    })->with(PasswordUpdateDatasets::validPasswords());

    it("Updates password without old password when configuration does not require it", function () {
        Event::fake();

        $oldPassword = "Old P@ssw0rd!#321";
        $newPassword = "NEW Old P@ssw0rd!#321 LOL";

        Config::set('settings.password_update_requires_old_password', false);

        $user = User::factory()->create([
            'password' => $oldPassword
        ]);

        HttpEndpoints::SELF_PASSWORD_UPDATE->tester()->sendAs($user, [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ])->expectOk('response.action.success');

        Event::assertDispatched(PasswordUpdated::class);

        Event::assertDispatched(UserActivity::class);
    });

    it("Requires old password when configuration requires it", function () {
        Event::fake();

        $oldPassword = "Old P@ssw0rd!#321";
        $newPassword = "NEW Old P@ssw0rd!#321 LOL";

        Config::set('settings.password_update_requires_old_password', true);

        $user = User::factory()->create([
            'password' => $oldPassword
        ]);

        HttpEndpoints::SELF_PASSWORD_UPDATE->tester()->sendAs($user, [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ])->expectValidationError(['old_password']);

        Event::assertNotDispatched(PasswordUpdated::class);

        Event::assertNotDispatched(UserActivity::class);
    });

    it("Updates password with old password when configuration requires it", function () {
        Event::fake();

        $oldPassword = "Old P@ssw0rd!#321";
        $newPassword = "NEW Old P@ssw0rd!#321 LOL";

        Config::set('settings.password_update_requires_old_password', true);

        $user = User::factory()->create([
            'password' => $oldPassword
        ]);

        HttpEndpoints::SELF_PASSWORD_UPDATE->tester()->sendAs($user, [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
            'old_password' => $oldPassword
        ])->expectOk('response.action.success');

        Event::assertDispatched(PasswordUpdated::class);

        Event::assertDispatched(UserActivity::class);
    });

    it("Validates old password", function () {
        Event::fake();

        $oldPassword = "Old P@ssw0rd!#321";
        $newPassword = "NEW Old P@ssw0rd!#321 LOL";

        Config::set('settings.password_update_requires_old_password', true);

        $user = User::factory()->create([
            'password' => $oldPassword
        ]);

        HttpEndpoints::SELF_PASSWORD_UPDATE->tester()->sendAs($user, [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
            'old_password' => "An incorrect password"
        ])->expectForbidden();

        Event::assertNotDispatched(PasswordUpdated::class);

        Event::assertNotDispatched(UserActivity::class);
    });
});
