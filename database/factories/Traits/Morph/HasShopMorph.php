<?php

namespace Database\Factories\Traits\Morph;

use App\Models\Shop;
use Database\Factories\ShopFactory;

trait HasShopMorph
{
    use HasMorph;

    /**
     * Associates the current model with a Shop model.
     *
     * @param  ShopFactory|null  $factory  An optional ShopFactory instance to create the Shop model.
     */
    final public function morphShop(?ShopFactory $factory = null): static
    {
        return $this->forFactory($factory ?? Shop::factory());
    }
}
