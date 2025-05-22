<?php

namespace App\Http\Controllers\API\Auth;

use App\Enums\UserAction;
use App\Events\PasswordUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Logics\AppResponse;
use Illuminate\Http\Request;

class UpdatePasswordController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdatePasswordRequest $request)
    {
        $user = $request->user();

        $user->recordAction(UserAction::UPDATE_PROFILE);

        $user->update([
            'password' => $request->validated('password'),
            'password_last_updated_at' => now(),
        ]);

        event(new PasswordUpdated($user));

        return AppResponse::ok(__('response.action.success'));
    }
}
