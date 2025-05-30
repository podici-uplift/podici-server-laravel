<?php

namespace App\Http\Controllers\API\Media;

use App\Enums\Media\MediaPurpose;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\UploadImageRequest;
use App\Http\Resources\MediaResource;
use App\Managers\MediaManager;
use App\Support\AppResponse;

/**
 * Upload Image Controller
 *
 * @tags Media
 */
class UploadImageController extends Controller
{
    /**
     * Upload Image
     */
    public function __invoke(UploadImageRequest $request)
    {
        try {
            $purpose = $request->safe()->enum('purpose', MediaPurpose::class);

            $request->user();

            $request->string('image');

            $media = MediaManager::upload(
                $request->user(),
                $request->file('image'),
                $purpose,
            );

            return AppResponse::resource(
                new MediaResource($media)
            );
        } catch (\Throwable $th) {
            return AppResponse::serverError($th->getMessage());
        }
    }
}
