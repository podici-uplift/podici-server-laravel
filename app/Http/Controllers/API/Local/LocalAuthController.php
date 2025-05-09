<?php

namespace App\Http\Controllers\API\Local;

use App\Actions\AuthActions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocalAuthController extends Controller
{
    public function authFromEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = AuthActions::getOrCreateUserUsingEmail($request->email);

        return AuthActions::authenticateUserAndRespond($user, "Local auth via email");
    }
}
