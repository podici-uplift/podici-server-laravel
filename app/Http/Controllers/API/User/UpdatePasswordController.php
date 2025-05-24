<?php

namespace App\Http\Controllers\API\User;

use App\Enums\UserAction;
use App\Events\PasswordUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdatePasswordRequest;
use App\Logics\AppResponse;
use Illuminate\Support\Facades\Hash;

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

        if (! $this->oldPasswordIsValid($request)) return AppResponse::forbidden();

        $user->recordAction(UserAction::UPDATE_PROFILE);

        $user->update([
            'password' => $request->validated('password'),
        ]);

        $this->invalidateOldLogins($request);

        $user->recordFieldUpdate('password');

        event(new PasswordUpdated($user));

        return AppResponse::actionSuccess();
    }

    private function oldPasswordIsValid(UpdatePasswordRequest $request): bool
    {
        if (! $request->user()->has_setup_password) return true;

        $verifyOldPassword = config('settings.password_update_requires_old_password');

        if (! $verifyOldPassword) return true;

        $providedOldPassword = $request->safe()->string('old_password');
        $storedHashedPassword = $request->user()->password;

        return Hash::check($providedOldPassword, $storedHashedPassword);
    }

    private function invalidateOldLogins(UpdatePasswordRequest $request)
    {
        if (! $request->safe()->boolean('invalidate_logins')) return;

        $request->user()->tokens()->where(
            'id',
            '!=',
            optional($request->user()->currentAccessToken())->id
        )->delete();
    }
}
