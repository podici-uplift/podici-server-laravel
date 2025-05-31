<?php

namespace Database\Factories;

use App\Enums\ContactType;
use App\Models\Shop;
use Database\Factories\Traits\Morph\HasMediaMorph;
use Database\Factories\Traits\Morph\HasProductMorph;
use Database\Factories\Traits\Morph\HasShopMorph;
use Database\Factories\Traits\Morph\HasUserMorph;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contact>
 */
class ContactFactory extends Factory
{
    use HasMediaMorph;
    use HasProductMorph;
    use HasShopMorph;
    use HasUserMorph;

    protected function getMorphNameBase(): string
    {
        return 'contactable';
    }

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
