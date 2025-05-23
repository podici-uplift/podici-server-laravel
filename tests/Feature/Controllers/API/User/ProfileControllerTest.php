<?php

use App\Events\ProfileUpdated;
use App\Events\UserActivity;
use App\Models\User;
use Tests\Datasets\ProfileUpdateDatasets;
use Tests\Helpers\Enums\HttpEndpoints;

describe('Get Profile', function () {
    it('Requires authentication', function () {
        HttpEndpoints::SELF_PROFILE->tester()->send()
            ->expectAuthenticationError();
    });

    it('Gets correct profile', function () {
        $user = User::factory()->create();

        HttpEndpoints::SELF_PROFILE->tester()->sendAs($user)
            ->expectResource()
            ->expectAll([
                'resource.id' => $user->id,
                'resource.username' => $user->username,
            ]);
    });
});

describe('Update Profile', function () {
    it('Requires auth', function () {
        HttpEndpoints::SELF_PROFILE_UPDATE->tester()->send()->expectAuthenticationError();
    });

    it('Requires at least on field', function () {
        $user = User::factory()->create();

        HttpEndpoints::SELF_PROFILE_UPDATE->tester()->sendAs($user, [])->expectValidationError();
    });

    it('Validates payloads individualy', function (string $field, string $value) {
        $user = User::factory()->create();

        HttpEndpoints::SELF_PROFILE_UPDATE->tester()->sendAs($user, [
            $field => $value,
        ])->expectValidationError([$field]);
    })->with(ProfileUpdateDatasets::formErrors());

    it('Validates payloads with damaged fields', function (string $field, string $value) {
        $user = User::factory()->create();

        $payload = httpPayload()->profileUpdate()->mod($field, $value)->data();

        HttpEndpoints::SELF_PROFILE_UPDATE->tester()->sendAs($user, $payload)->expectValidationError([$field]);
    })->with(ProfileUpdateDatasets::formErrors());

    it('Profile Can update', function () {
        Event::fake();

        $user = User::factory()->create();

        $payload = httpPayload()->profileUpdate()->data();

        HttpEndpoints::SELF_PROFILE_UPDATE->tester()->sendAs($user, $payload)->expectOk('response.action.success');

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
