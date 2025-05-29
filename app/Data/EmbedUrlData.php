<?php

namespace App\Data;

use App\Enums\Media\VideoEmbedPlatforms;

class EmbedUrlData
{
    public function __construct(
        public readonly VideoEmbedPlatforms $platform,
        public readonly string $url,
        public readonly string $thumbnail,
        public readonly string $code,
        public readonly string $title,
        public readonly string $authorName,
    ) {
        //
    }
}
