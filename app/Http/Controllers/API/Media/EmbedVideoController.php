<?php

namespace App\Http\Controllers\API\Media;

use App\Http\Controllers\Controller;
use App\Http\Requests\Media\EmbedVideoRequest;
use Illuminate\Http\Request;

/**
 * Embed Video Controller
 *
 * @tags Media
 */
class EmbedVideoController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(EmbedVideoRequest $request)
    {
        //
    }
}
