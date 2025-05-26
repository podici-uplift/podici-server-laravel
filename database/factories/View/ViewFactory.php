<?php

namespace Database\Factories\View;

use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\View>
 */
class ViewFactory extends Factory
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
            'date' => now(),
        ];
    }

    public function viewDate(string $date): Factory
    {
        return $this->state(fn(array $attributes) => ['date' => $date,]);
    }

    public function forModel(Model $model): static
    {
        return $this->state(fn(array $attributes) => [
            'viewable_type' => $model->getMorphClass(),
            'viewable_id' => $model->getKey(),
        ]);
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
                'viewable_type' => $model->getMorphClass(),
                'viewable_id' => $model->getKey(),
            ];
        });
    }
}
