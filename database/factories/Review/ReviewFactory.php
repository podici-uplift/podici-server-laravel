<?php

namespace Database\Factories\Review;

use App\Enums\Review\ReviewRating;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review\Review>
 */
class ReviewFactory extends Factory
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
            'title' => fake()->realText(24),
            'review' => fake()->realText(),
            'response' => fake()->realText(),
            'rating' => fake()->randomElement(ReviewRating::cases()),
        ];
    }

    public function forModel(Model $model): static
    {
        return $this->state(fn (array $attributes) => [
            'reviewable_type' => $model->getMorphClass(),
            'reviewable_id' => $model->getKey(),
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
                'reviewable_type' => $model->getMorphClass(),
                'reviewable_id' => $model->getKey(),
            ];
        });
    }
}
