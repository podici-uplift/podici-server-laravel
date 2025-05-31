<?php

namespace Database\Factories\Traits\Morph;

use App\Models\Product;
use Database\Factories\ProductFactory;

trait HasProductMorph
{
    use HasMorph;

    /**
     * Associates the current model with a Product model.
     *
     * @param  ProductFactory|null  $factory  An optional ProductFactory instance to create the Product model.
     */
    final public function morphProduct(?ProductFactory $factory = null): static
    {
        return $this->forFactory($factory ?? Product::factory());
    }
}
