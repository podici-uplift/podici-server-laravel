<?php

namespace App\Http\Controllers\API\Lookup;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Rules\Regex\ShopNameRegexRule;
use App\Support\AppResponse;
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
            'is_available' => Shop::nameUsed($request->name),
            'slug' => Shop::sluggifyName($request->name),
        ]);
    }
}
