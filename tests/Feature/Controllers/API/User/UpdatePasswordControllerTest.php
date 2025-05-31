<?php

use App\Events\PasswordUpdated;
use App\Events\UserActivity;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Tests\Datasets\PasswordUpdateDatasets;
use Tests\Helpers\Enums\HttpEndpoints;
use Tests\Helpers\HttpTester;

beforeAll(function () {
    Http::fake();
});

describe('Update Password Success Cases', function () {
    it('Sets up new password correctly', function ($validPassword) {
        $user = userFactory()->noPassword()->create();

        updatePasswordAs($user, [
            'password' => $validPassword,
            'password_confirmation' => $validPassword,
        ])->expectOk('response.action.success');

        assertPasswordUpdated($user, $validPassword);
    })->with(PasswordUpdateDatasets::validPasswords());

    it('Updates password without old password when configuration does not require it', function () {
        $oldPassword = 'Old P@ssw0rd!#321';
        $newPassword = 'NEW Old P@ssw0rd!#321 LOL';

        Config::set('settings.password_update_requires_old_password', false);

        $user = userFactory()->password($oldPassword)->create();

        updatePasswordAs($user, [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ])->expectOk('response.action.success');

        assertPasswordUpdated($user, $newPassword);
    });

    it('Updates password with old password when configuration requires it', function () {
        $oldPassword = 'Old P@ssw0rd!#321';
        $newPassword = 'NEW Old P@ssw0rd!#321 LOL';

        Config::set('settings.password_update_requires_old_password', true);

        $user = userFactory()->password($oldPassword)->create();

        updatePasswordAs($user, [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
            'old_password' => $oldPassword,
        ])->expectOk('response.action.success');

        assertPasswordUpdated($user, $newPassword);
    });
});

describe('Update Password Error Cases', function () {
    it('Requires auth', function () {
        HttpEndpoints::SELF_PASSWORD_UPDATE->tester()->send()->expectAuthenticationError();
    });

    it('Requires confirmation to be valid', function () {
        $user = createUser();

        updatePasswordAs($user, [
            'password' => 'A valid password#',
            'password_confirmation' => 'A valid password',
        ])->expectValidationError(['password']);

        assertPasswordNotUpdated();
    });

    it('Requires a valid password', function ($invalidPassword) {
        $user = createUser();

        updatePasswordAs($user, [
            'password' => $invalidPassword,
            'password_confirmation' => $invalidPassword,
        ])->expectValidationError(['password']);

        assertPasswordNotUpdated();
    })->with(PasswordUpdateDatasets::invalidPasswords());

    it('Requires old password when configuration requires it', function () {
        $oldPassword = 'Old P@ssw0rd!#321';
        $newPassword = 'NEW Old P@ssw0rd!#321 LOL';

        Config::set('settings.password_update_requires_old_password', true);

        $user = userFactory()->password($oldPassword)->create();

        updatePasswordAs($user, [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ])->expectValidationError(['old_password']);

        assertPasswordNotUpdated();
    });

    it('Validates old password', function () {
        $oldPassword = 'Old P@ssw0rd!#321';
        $newPassword = 'NEW Old P@ssw0rd!#321 LOL';

        Config::set('settings.password_update_requires_old_password', true);

        $user = userFactory()->password($oldPassword)->create();

        updatePasswordAs($user, [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
            'old_password' => 'An incorrect password',
        ])->expectForbidden();

        assertPasswordNotUpdated();
    });
});

function updatePasswordAs(User $user, array $payload): HttpTester
{
    return HttpEndpoints::SELF_PASSWORD_UPDATE->tester()->sendAs($user, $payload);
}

function assertPasswordNotUpdated()
{
    Event::assertNotDispatched(PasswordUpdated::class);
    Event::assertNotDispatched(UserActivity::class);
}

function assertPasswordUpdated(User $user, string $password)
{
    Event::assertDispatched(PasswordUpdated::class);
    Event::assertDispatched(UserActivity::class);

    $passwordMatch = Hash::check($password, $user->password);
    expect($passwordMatch)->toBeTrue();
}
