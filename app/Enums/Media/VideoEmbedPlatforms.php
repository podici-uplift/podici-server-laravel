<?php

namespace App\Enums\Media;

enum VideoEmbedPlatforms: string
{
    case YOUTUBE = 'youtube';
    case TIKTOK = 'tiktok';
    case VIMEO = 'vimeo';

    public function regexPattern(): string
    {
        return match ($this) {
            VideoEmbedPlatforms::YOUTUBE => '/^https?:\/\/(?:www\.)?youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',

            VideoEmbedPlatforms::TIKTOK => '/^https?:\/\/(?:(www|vm)\.)?tiktok\.com\/([a-zA-Z0-9]+)/',

            VideoEmbedPlatforms::VIMEO => '/^https?:\/\/(?:www\.)?vimeo\.com\/([0-9]+)/',
        };
    }
}
