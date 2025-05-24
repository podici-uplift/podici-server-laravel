<?php

namespace App\Http\Controllers\API\User;

use App\Enums\UserAction;
use App\Events\ProfileUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Resources\Auth\UserResource;
use App\Logics\AppResponse;
use Illuminate\Http\Request;

/**
 * Profile Controller
 *
 * @tags User
 */
class ProfileController extends Controller
{
    /**
     * Get Profile
     */
    public function index(Request $request)
    {
        return AppResponse::resource(
            new UserResource($request->user()),
        );
    }

    /**
     * Update Profile
     */
    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $user->update($request->validated());

        $user->recordAction(UserAction::UPDATE_PROFILE);

        event(new ProfileUpdated($user));

        return AppResponse::actionSuccess();
    }
}
