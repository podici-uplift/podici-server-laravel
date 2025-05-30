<?php

namespace App\Http\Controllers\API\Media;

use App\Enums\Media\MediaPurpose;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\EmbedVideoRequest;
use App\Http\Resources\MediaResource;
use App\Managers\MediaManager;
use App\Processors\ResolveEmbedUrlProcessor;
use App\Support\AppResponse;

/**
 * Embed Video Controller
 *
 * @tags Media
 */
class EmbedVideoController extends Controller
{
    /**
     * Embed Video
     */
    public function __invoke(EmbedVideoRequest $request)
    {
        try {
            $purpose = $request->safe()->enum('purpose', MediaPurpose::class);

            if (! optional($purpose)->supportsVideo()) {
                return AppResponse::badRequest(__('validation.media_purpose_prohibits_videos', [
                    'attribute' => 'purpose',
                ]));
            }

            $embedUrlProcessor = new ResolveEmbedUrlProcessor(
                $request->safe()->string('url')
            );

            $data = $embedUrlProcessor->execute();

            if (! $data) {
                return AppResponse::badRequest(__('validation.embed_video_link_invalid', [
                    'attribute' => 'url',
                ]));
            }

            $media = MediaManager::storeEmbed($request->user(), $purpose, $data);

            return AppResponse::resource(
                new MediaResource($media)
            );
        } catch (\Throwable $th) {
            return AppResponse::serverError($th->getMessage());
        }
    }
}
