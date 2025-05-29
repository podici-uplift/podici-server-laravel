<?php

namespace Tests\Datasets;

use App\Enums\Media\MediaPurpose;
use App\Enums\Media\VideoEmbedPlatforms;

class EmbedVideoRequestDatasets
{
    public static function validUrls()
    {
        $builder = fn(VideoEmbedPlatforms $platform, string $url) => [
            'platform' => $platform->value,
            'url' => $url,
            'purpose' => MediaPurpose::OTHER->value,
        ];

        $youtube = fn(string $url) => $builder(VideoEmbedPlatforms::YOUTUBE, $url);

        $tiktok = fn(string $url) => $builder(VideoEmbedPlatforms::TIKTOK, $url);

        $vimeo = fn(string $url) => $builder(VideoEmbedPlatforms::VIMEO, $url);

        $uniqueId = uniqid();

        return [
            $youtube("https://www.youtube.com/watch?v=$uniqueId"),
            $youtube("https://youtube.com/watch?v=$uniqueId"),

            $tiktok("https://www.tiktok.com/$uniqueId"),
            $tiktok("https://vm.tiktok.com/$uniqueId"),
            $tiktok("https://tiktok.com/$uniqueId"),

            $vimeo("https://vimeo.com/$uniqueId"),
        ];
    }
}
