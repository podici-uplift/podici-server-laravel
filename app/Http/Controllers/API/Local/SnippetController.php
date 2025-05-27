<?php

namespace App\Http\Controllers\API\Local;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\View\DailyView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Snippet Controller
 *
 * @tags Local
 */
class SnippetController extends Controller
{
    public function __invoke(Request $request)
    {
        return $this->viewQueriesSql($request);
    }

    private function incrementTest(Request $request)
    {
        $viewable = User::first();

        DailyView::updateOrCreate([
            'viewable_type' => $viewable->getMorphClass(),
            'viewable_id' => $viewable->getKey(),
            'date' => now()->format('Y-m-d'),
        ], [
            'views' => 0,
        ])->increment('views', 12);
    }

    private function viewQueriesSql(Request $request)
    {
        $user = User::first();

        DB::enableQueryLog();

        $user->totalViewCount(false);

        return DB::getRawQueryLog();
    }
}
