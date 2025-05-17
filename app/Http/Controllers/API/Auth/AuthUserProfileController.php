<?php

namespace App\Http\Controllers\API\Auth;

use App\Enums\UserAction;
use App\Events\ProfileUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\Auth\UserResource;
use App\Logics\AppResponse;
use Illuminate\Http\Request;

class AuthUserProfileController extends Controller
{
    public function index(Request $request)
    {
        return AppResponse::resource(
            new UserResource($request->user()),
        );
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $user->update($request->validated());

        $user->recordAction(UserAction::PROFILE_UPDATE);

        event(new ProfileUpdated($user));

        return AppResponse::ok(__('response.action.success'));
    }
}
