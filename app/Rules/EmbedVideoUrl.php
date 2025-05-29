<?php

namespace App\Rules;

use App\Enums\Media\VideoEmbedPlatforms;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;

class EmbedVideoUrl implements ValidationRule, DataAwareRule
{
    protected VideoEmbedPlatforms $platform;

    public function setData(array $data): static
    {
        $this->platform = VideoEmbedPlatforms::from($data['platform']);

        return $this;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! str($value)->test($this->platform->regexPattern())) {
            $fail('validations.embed_video_link_invalid')->translate([
                'platform' => $this->platform->value,
            ]);
        }
    }
}
