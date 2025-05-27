<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->words(3, true);

        return [
            'shop_id' => Shop::factory(),
            'name' => $name,
            'slug' => str($name)->slug(),
            'description' => fake()->paragraph(2),
            'long_description' => fake()->paragraph(5),
            'owner_notes' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 0, 100),
            'sale_price' => fake()->randomFloat(2, 0, 100),
            'currency' => fake()->randomElement(Currency::cases()),
            'quantity_left' => fake()->randomNumber(),
            'is_adult' => fake()->boolean(),
        ];
    }
}
