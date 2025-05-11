<?php

namespace App\Http\Controllers\API;

use App\Enums\UserAction;
use App\Events\PasswordUpdated;
use App\Events\ProfileUpdated;
use App\Events\UsernameSetup;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SetupUsernameRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Http\Resources\Auth\UserResource;
use App\Logics\AppResponse;
use Illuminate\Http\Request;

class AuthUserController extends Controller
{
    public function getProfile(Request $request)
    {
        return new UserResource($request->user());
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $user->recordAction(UserAction::PROFILE_UPDATE);

        $user->update($request->validated());

        event(new ProfileUpdated($user));

        return AppResponse::ok('Profile updated successfully');
    }

    public function updateUsername(SetupUsernameRequest $request)
    {
        $user = $request->user();

        $user->recordAction(UserAction::PROFILE_UPDATE);

        $user->update([
            'username' => $request->validated('username'),
            'username_last_updated_at' => now(),
        ]);

        event(new UsernameSetup($user));

        return AppResponse::ok("Username setup successfully");
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = $request->user();

        $user->recordAction(UserAction::PROFILE_UPDATE);

        $user->update([
            'password' => $request->validated('password'),
            'password_last_updated_at' => now(),
        ]);

        event(new PasswordUpdated($user));

        return AppResponse::ok('Password updated successfully');
    }

    public function logout(Request $request)
    {
        /** @var \Laravel\Sanctum\PersonalAccessToken $currentToken * */
        $currentToken = $request->user()->currentAccessToken();

        $currentToken->delete();
    }
}
