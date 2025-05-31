<?php

namespace Database\Factories;

use App\Enums\Media\MediaPurpose;
use App\Models\User;
use Database\Factories\Traits\Morph\HasProductMorph;
use Database\Factories\Traits\Morph\HasShopMorph;
use Database\Factories\Traits\Morph\HasUserMorph;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    use HasProductMorph;
    use HasShopMorph;
    use HasUserMorph;

    protected function getMorphNameBase(): string
    {
        return 'mediable';
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uploaded_by' => User::factory(),
            'disk' => 'raw',
            'path' => fake()->imageUrl(),
            'original_name' => uniqid(),
            'mime_type' => 'image/jpeg',
            'size' => fake()->randomNumber(4),
            'purpose' => fake()->randomElement(MediaPurpose::cases()),
        ];
    }
}
