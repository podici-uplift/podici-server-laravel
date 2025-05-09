<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthUserController extends Controller
{
    public function profile(Request $request)
    {
        return $request->user()->toResource();
    }

    public function logout(Request $request)
    {
        /** @var \Laravel\Sanctum\PersonalAccessToken $currentToken **/
        $currentToken = $request->user()->currentAccessToken();

        $currentToken->delete();
    }
}
