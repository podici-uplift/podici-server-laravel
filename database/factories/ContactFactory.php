<?php

namespace Database\Factories;

use App\Enums\ContactType;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contactable' => Shop::factory(),
            'type' => fake()->randomElement(ContactType::cases()),
            'label' => fake()->sentence(),
            'value' => fake()->url(),
            'is_primary' => fake()->boolean(),
        ];
    }
}
