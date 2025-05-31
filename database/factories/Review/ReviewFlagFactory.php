<?php

namespace Database\Factories\Review;

use App\Enums\Review\ReviewFlagType;
use App\Models\Review\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review\ReviewFlag>
 */
class ReviewFlagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'review_id' => Review::factory(),
            'flagged_by' => User::factory(),
            'type' => fake()->randomElement(ReviewFlagType::cases()),
            'submissions' => fake()->randomNumber(),
            'reason' => fake()->sentence(),
        ];
    }
}
