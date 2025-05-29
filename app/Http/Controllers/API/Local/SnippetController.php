<?php

namespace App\Http\Controllers\API\Local;

use App\Http\Controllers\Controller;
use App\Support\AppResponse;
use Illuminate\Http\Request;

/**
 * Snippet Controller
 *
 * @tags Local
 */
class SnippetController extends Controller
{
    public function __invoke(Request $request)
    {
        return AppResponse::ok();
    }
}
