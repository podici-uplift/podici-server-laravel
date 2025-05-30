<?php

namespace Database\Factories\Traits\Morph;

use App\Models\Media;
use Database\Factories\MediaFactory;

trait HasMediaMorph
{
    use HasMorph;

    /**
     * Associates the current model with a Media model.
     *
     * @param  MediaFactory|null  $factory  An optional MediaFactory instance to create the Media model.
     */
    public function morphMedia(?MediaFactory $factory = null): static
    {
        return $this->forFactory($factory ?? Media::factory());
    }
}
