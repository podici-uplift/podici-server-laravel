<?php

namespace Database\Factories\Traits\Morph;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

trait HasMorph
{
    final public function forModel(Model $model): static
    {
        $baseName = $this->getMorphNameBase();

        return $this->state(fn (array $attributes) => [
            "{$baseName}_type" => $model->getMorphClass(),
            "{$baseName}_id" => $model->getKey(),
        ]);
    }

    abstract protected function getMorphNameBase(): string;

    final protected function forFactory(Factory $factory): static
    {
        return $this->state(function (array $attributes) use ($factory) {
            $model = $factory->create();

            $baseName = $this->getMorphNameBase();

            return [
                "{$baseName}_type" => $model->getMorphClass(),
                "{$baseName}_id" => $model->getKey(),
            ];
        });
    }
}
