<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Logout Controller
 *
 * @tags Auth
 */
class LogoutController extends Controller
{
    /**
     * Logout
     */
    public function __invoke(Request $request)
    {
        /** @var \Laravel\Sanctum\PersonalAccessToken $currentToken * */
        $currentToken = $request->user()->currentAccessToken();

        $currentToken->delete();
    }
}
