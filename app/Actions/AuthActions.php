<?php

namespace App\Actions;

use App\Models\User;
use Auth;

class AuthActions
{
    public static function getOrCreateUserUsingEmail(string $email): User
    {
        return User::firstOrCreate([
            'email' => $email,
        ], [
            'email_verified_at' => now(),
            'last_activity_at' => now(),
            'password' => null,
        ]);
    }

    public static function authenticateUserAndRespond(
        User $user,
        string $tokenName
    ): \Illuminate\Http\JsonResponse {
        $token = $user->createToken($tokenName);

        Auth::login($user);

        return response()->json([
            'status' => 200,
            'message' => 'Authentication Successful',
            'token' => $token->plainTextToken,
            'user' => $user->toResource(),
        ]);
    }
}
