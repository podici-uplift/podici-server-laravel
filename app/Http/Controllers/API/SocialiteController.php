<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Handle callback from provider
     *
     * @unauthenticated
     *
     * @return void
     */
    public function handleProviderCallback(string $provider)
    {
        try {
            $socialiteUser = Socialite::driver($provider)->stateless()->user();

            return $this->authenticateSocialiteUser($socialiteUser, $provider);
        } catch (\Throwable $th) {
            report($th);

            return response()->json(status: Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Get Bearer token using provider token
     *
     * @unauthenticated
     *
     * @return void
     */
    public function authFromToken(Request $request, string $provider)
    {
        $request->validate([
            'token' => ['required', 'string'],
        ]);

        try {
            $socialiteUser = Socialite::driver($provider)->stateless()->userFromToken($request->token);

            return $this->authenticateSocialiteUser($socialiteUser, $provider);
        } catch (\Throwable $th) {
            report($th);

            return response()->json(status: Response::HTTP_BAD_REQUEST);
        }
    }

    protected function authenticateSocialiteUser($socialiteUser, $provider)
    {
        $userEmail = $socialiteUser->getEmail();

        /** @var User $user */
        $user = User::firstOrCreate([
            'email' => $userEmail,
        ], [
            'name' => uniqid('user_'),
            'email_verified_at' => now(),
            'password' => null,
        ]);

        if ($user->wasRecentlyCreated) {
            // If the user was just created, you might want to send a welcome email or perform other actions.
        }

        $token = $user->createToken(
            "Social Login with {$provider}"
        );

        return response()->json([
            'status' => 200,
            'message' => 'Authentication Successful',
            'token' => $token->plainTextToken,
            // 'user' => new AuthUserResource($user),
        ]);
    }
}
