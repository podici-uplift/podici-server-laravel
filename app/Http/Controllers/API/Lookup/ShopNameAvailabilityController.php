<?php

namespace App\Http\Controllers\API\Lookup;

use App\Http\Controllers\Controller;
use App\Logics\AppResponse;
use App\Logics\ShopName;
use App\Rules\Regex\ShopNameRegexRule;
use Illuminate\Http\Request;

/**
 * Shop Name Availability Controller
 *
 * @tags Lookup
 */
class ShopNameAvailabilityController extends Controller
{
    /**
     * Shop name availability lookup
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', new ShopNameRegexRule],
        ]);

        return AppResponse::ok(__('response.action.success'), [
            'is_available' => ShopName::isAvailable($request->name),
            'slug' => ShopName::toSlug($request->name),
        ]);
    }
}
