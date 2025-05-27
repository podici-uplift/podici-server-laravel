<?php

namespace App\Http\Controllers\API\User\Shop;

use App\Enums\UserAction;
use App\Events\ShopAdultStatusUpdated;
use App\Events\ShopNameUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\Shop\UpdateShopRequest;
use App\Logics\AppResponse;

/**
 * Update Shop Controller
 *
 * @tags User
 */
class UpdateShopController extends Controller
{
    /**
     * Update Shop
     */
    public function __invoke(UpdateShopRequest $request)
    {
        $user = $request->user();

        $request->user()->shop()->update($request->safe([
            'name',
            'description',
            'is_adult_shop',
            'status',
        ]));

        if ($request->safe()->filled('name')) {
            event(new ShopNameUpdated(
                $user,
                $user->shop,
                $request->safe()->string('name_update_message')
            ));
        }

        if ($request->safe()->filled('is_adult_shop')) {
            event(new ShopAdultStatusUpdated($user, $user->shop));
        }

        $user->recordAction(UserAction::UPDATE_SHOP);

        return AppResponse::actionSuccess();
    }
}
