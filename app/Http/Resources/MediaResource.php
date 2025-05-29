<?php

namespace App\Http\Resources;

use App\Managers\MediaManager;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'url' => MediaManager::getUrl($this->resource),
            'purpose' => $this->purpose,
            'meta' => $this->meta,
            'size' => $this->size,
            'embed' => $this->when($this->disk == MediaManager::RAW_DISK, function () {
                return [
                    'platform' => $this->embed_platform,
                    'thumbnail' => $this->embed_thumbnail,
                    'code' => $this->embed_code,
                ];
            }),
        ];
    }
}
