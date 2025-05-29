<?php

namespace App\Http\Controllers\API\User;

use App\Enums\UserAction;
use App\Events\UsernameSetup;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SetupUsernameRequest;
use App\Support\AppResponse;

/**
 * Update username controller
 *
 * @tags User
 */
class UpdateUsernameController extends Controller
{
    /**
     * Update username
     */
    public function __invoke(SetupUsernameRequest $request)
    {
        $user = $request->user();

        $user->recordAction(UserAction::UPDATE_PROFILE);

        $user->update([
            'username' => $request->validated('username'),
        ]);

        event(new UsernameSetup($user));

        return AppResponse::actionSuccess();
    }
}
