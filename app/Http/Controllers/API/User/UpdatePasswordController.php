<?php

namespace App\Http\Controllers\API\User;

use App\Enums\UserAction;
use App\Events\PasswordUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Logics\AppResponse;

/**
 * Update Password Controller
 *
 * @tags User
 */
class UpdatePasswordController extends Controller
{
    /**
     * Update password
     */
    public function __invoke(UpdatePasswordRequest $request)
    {
        $user = $request->user();

        $user->recordAction(UserAction::UPDATE_PROFILE);

        $user->update([
            'password' => $request->validated('password'),
        ]);

        event(new PasswordUpdated($user, $request->safe()->boolean('invalidate_logins')));

        return AppResponse::actionSuccess();
    }
}
