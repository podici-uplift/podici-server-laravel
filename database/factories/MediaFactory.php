<?php

namespace Database\Factories;

use App\Enums\Media\MediaStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
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
            'disk' => 'test',
            'path' => fake()->filePath(),
            'original_name' => uniqid(),
            'mime_type' => 'image/jpeg',
            'size' => fake()->randomNumber(4),
            'status' => fake()->randomElement(MediaStatus::cases()),
            'purpose' => fake()->realText()
        ];
    }
}
