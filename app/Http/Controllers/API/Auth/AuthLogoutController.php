<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthLogoutController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        /** @var \Laravel\Sanctum\PersonalAccessToken $currentToken * */
        $currentToken = $request->user()->currentAccessToken();

        $currentToken->delete();
    }
}
