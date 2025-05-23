<?php

namespace App\Http\Controllers\API\Auth;

use App\Enums\ShopStatus;
use App\Enums\UserAction;
use App\Events\ShopCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateShopRequest;
use App\Http\Resources\ShopResource;
use App\Logics\AppResponse;
use Illuminate\Http\Request;

/**
 * Create Shop Controller
 *
 * @tags Auth
 */
class CreateShopController extends Controller
{
    /**
     * Create shop
     */
    public function __invoke(CreateShopRequest $request)
    {
        $user = $request->user();

        $user->recordAction(UserAction::CREATE_SHOP);

        $shop = $user->shop()->create([
            'name' => $request->validated('name'),
            'is_adult_shop' => $request->validated('is_adult_shop'),
            'status' => ShopStatus::DRAFT,
        ]);

        event(new ShopCreated($user, $shop));

        return AppResponse::resource(
            new ShopResource($shop)
        );
    }
}
