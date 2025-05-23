<?php

namespace App\Http\Controllers\API\Auth;

use App\Actions\AuthActions;
use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Socialite\Facades\Socialite;

/**
 * Socialite Controller
 *
 * @tags Socialite
 */
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
        $user = AuthActions::getOrCreateUserUsingEmail($socialiteUser->getEmail());

        if ($user->wasRecentlyCreated) {
            event(new UserRegistered($user));
        }

        return AuthActions::authenticateUserAndRespond($user, "Social Login with {$provider}");
    }
}
