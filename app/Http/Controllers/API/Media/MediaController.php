<?php

namespace App\Http\Controllers\API\Media;

use App\Http\Controllers\Controller;
use App\Http\Resources\MediaResource;
use App\Managers\MediaManager;
use App\Support\AppResponse;
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

        $medias = $request->user()->uploadedMedias()->cursorPaginate(
            $request->input('per_page', 15)
        );

        return MediaResource::collection($medias);
    }

    /**
     * Delete uploaded media
     */
    public function destroy(Request $request, string $media_id)
    {
        try {
            $media = $request->user()->uploadedMedias()->find($media_id);

            if ($media->mediable !== null) {
                return AppResponse::badRequest();
            }

            MediaManager::delete($media);

            return AppResponse::actionSuccess();
        } catch (\Throwable $th) {
            return AppResponse::serverError($th->getMessage());
        }
    }
}
