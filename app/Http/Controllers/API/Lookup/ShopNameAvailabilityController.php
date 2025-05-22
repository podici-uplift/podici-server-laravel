<?php

namespace App\Http\Controllers\API\Lookup;

use App\Http\Controllers\Controller;
use App\Logics\AppResponse;
use App\Logics\ShopName;
use App\Rules\Regex\ShopName as ShopNameRule;
use Illuminate\Http\Request;

class ShopNameAvailabilityController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', new ShopNameRule],
        ]);

        return AppResponse::ok(__('response.action.success'), [
            'is_available' => ShopName::isAvailable($request->name),
            'slug' => ShopName::toSlug($request->name),
        ]);
    }
}
