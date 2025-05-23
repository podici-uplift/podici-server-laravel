<?php

namespace App\Http\Controllers\API\Local;

use App\Actions\AuthActions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Local Auth Controller
 *
 * @tags Local
 */
class LocalAuthController extends Controller
{
    /**
     * Local auth from email
     */
    public function authFromEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = AuthActions::getOrCreateUserUsingEmail($request->email);

        return AuthActions::authenticateUserAndRespond($user, 'Local auth via email');
    }
}
