<?php

namespace Database\Factories\Traits\Morph;

use App\Models\User;
use Database\Factories\UserFactory;

trait HasUserMorph
{
    use HasMorph;

    /**
     * Associates the current model with a User model.
     *
     * @param  UserFactory|null  $factory  An optional UserFactory instance to create the User model.
     */
    final public function morphUser(?UserFactory $factory = null): static
    {
        return $this->forFactory($factory ?? User::factory());
    }
}
