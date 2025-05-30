<?php

namespace App\Processors;

use App\Data\EmbedUrlData;
use App\Enums\Media\VideoEmbedPlatforms;
use Embed\Embed;

class ResolveEmbedUrlProcessor
{
    protected Embed $embed;

    public function __construct(
        protected string $url
    ) {
        $this->embed = new Embed;
    }

    public function execute(): ?EmbedUrlData
    {
        $info = $this->embed->get($this->url);

        $providerName = str($info->providerName)->lower()->toString();

        $platform = VideoEmbedPlatforms::tryFrom($providerName);

        if (! $platform) {
            return null;
        }

        return new EmbedUrlData(
            platform: $platform,
            url: $info->url,
            thumbnail: $info->image,
            code: $info->code->html,
            title: $info->title,
            authorName: $info->authorName
        );
    }
}
