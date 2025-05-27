<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
        ];
    }

    public function product(): static
    {
        return $this->forFactory(Product::factory());
    }

    public function shop(): static
    {
        return $this->forFactory(Shop::factory());
    }

    public function user(): static
    {
        return $this->forFactory(User::factory());
    }

    private function forFactory(Factory $factory): static
    {
        return $this->state(function (array $attributes) use ($factory) {
            $model = $factory->create();

            return [
                'likeable_type' => $model->getMorphClass(),
                'likeable_id' => $model->getKey(),
            ];
        });
    }
}
