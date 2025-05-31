<?php

namespace Database\Factories\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasBelongsTo
{
    abstract protected function belongsToKey(): string;

    final public function belongsTo(Model $model): static
    {
        return $this->state(fn (array $attributes) => [
            $this->belongsToKey() => $model->getKey()
        ]);
    }
}
