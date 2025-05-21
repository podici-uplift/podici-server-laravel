<?php

use App\Events\ProfileUpdated;
use App\Events\UserActivity;
use App\Models\User;
use Tests\Datasets\ProfileUpdateDatasets;

describe('Get Profile', function () {
    it('Requires authentication', function () {
        httpTester('GET', 'api.auth.user.profile.index')->send()
            ->expectAuthenticationError();
    });

    it('Gets correct profile', function () {
        $user = User::factory()->create();

        httpTester('GET', 'api.auth.user.profile.index')->sendAs($user)
            ->expectResource()
            ->expectAll([
                'resource.id' => $user->id,
                'resource.username' => $user->username,
            ]);
    });
});

describe('Update Profile', function () {
    $baseTester = fn () => httpTester('PUT', 'api.auth.user.profile.update');

    it('Requires auth', function () use ($baseTester) {
        $baseTester()->send()->expectAuthenticationError();
    });

    it('Requires at least on field', function () use ($baseTester) {
        $user = User::factory()->create();

        $baseTester()->sendAs($user, [])->expectValidationError();
    });

    it('Validates payloads individualy', function (string $field, string $value) use ($baseTester) {
        $user = User::factory()->create();

        $baseTester()->sendAs($user, [
            $field => $value,
        ])->expectValidationError([$field]);
    })->with(ProfileUpdateDatasets::formErrors());

    it('Validates payloads with damaged fields', function (string $field, string $value) use ($baseTester) {
        $user = User::factory()->create();

        $payload = httpPayload()->profileUpdate()->mod($field, $value)->data();

        $baseTester()->sendAs($user, $payload)->expectValidationError([$field]);
    })->with(ProfileUpdateDatasets::formErrors());

    it('Profile Can update', function () use ($baseTester) {
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
