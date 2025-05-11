<?php

namespace App\Http\Controllers\API;

use App\Enums\UserAction;
use App\Events\PasswordUpdated;
use App\Events\ProfileUpdated;
use App\Events\UsernameSetup;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SetupUsernameRequest;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use Illuminate\Http\Request;

class AuthUserController extends Controller
{
    public function getProfile(Request $request)
    {
        return $request->user()->toResource();
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $user->recordAction(UserAction::PROFILE_UPDATE);

        $user->update($request->validated());

        event(new ProfileUpdated($user));

        return response()->json([
            'message' => 'Profile updated successfully',
        ]);
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

        return response()->json([
            'message' => 'Username setup successfully',
        ]);
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

        return response()->json([
            'message' => 'Password updated successfully',
        ]);
    }

    public function logout(Request $request)
    {
        /** @var \Laravel\Sanctum\PersonalAccessToken $currentToken * */
        $currentToken = $request->user()->currentAccessToken();

        $currentToken->delete();
    }
}
