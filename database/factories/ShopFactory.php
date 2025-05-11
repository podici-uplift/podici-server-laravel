<?php

namespace Database\Factories;

use App\Enums\ShopStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
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
            'name' => fake()->company(),
            'slug'=> fake()->slug(),
            'description' => fake()->realText(),
            'is_adult_shop' => fake()->boolean(),
            'status' => fake()->randomElement(ShopStatus::cases()),
        ];
    }
}
