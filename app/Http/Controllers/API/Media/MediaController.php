<?php

namespace App\Http\Controllers\API\Media;

use App\Http\Controllers\Controller;
use App\Http\Resources\MediaResource;
use App\Models\Media;
use App\Models\User;
use App\Support\AppResponse;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;

/**
 * Media Controller
 *
 * @tags Media
 */
class MediaController extends Controller
{
    /**
     * List uploaded medias
     */
    public function index(Request $request)
    {
        $request->input('cursor');

        /** @var Paginator $medias */
        $medias = $request->user()->uploadedMedias()->cursorPaginate(
            $request->input('per_page', 15)
        );

        return MediaResource::collection($medias);
    }

    /**
     * Delete uploaded media
     */
    public function destroy(string $media_id)
    {
        //
    }
}
