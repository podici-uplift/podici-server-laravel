<?php

namespace Database\Factories;

use App\Enums\ShopStatus;
use App\Models\Shop;
use App\Models\User;
use Database\Factories\Traits\HasBelongsTo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    use HasBelongsTo;

    protected function belongsToKey(): string
    {
        return 'owned_by';
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'owned_by' => User::factory(),
            'name' => str(fake()->company())->limit(
                Shop::nameLengthLimit(),
                end: ''
            ),
            'description' => fake()->sentence(),
            'is_adult_shop' => fake()->boolean(),
            'status' => fake()->randomElement(ShopStatus::cases()),
        ];
    }
}
