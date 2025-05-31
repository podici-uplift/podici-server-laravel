<?php

namespace Database\Factories\Review;

use App\Enums\Review\ReviewRating;
use App\Models\User;
use Database\Factories\Traits\HasBelongsTo;
use Database\Factories\Traits\Morph\HasProductMorph;
use Database\Factories\Traits\Morph\HasShopMorph;
use Database\Factories\Traits\Morph\HasUserMorph;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review\Review>
 */
class ReviewFactory extends Factory
{
    use HasProductMorph;
    use HasShopMorph;
    use HasUserMorph;
    use HasBelongsTo;

    protected function getMorphNameBase(): string
    {
        return 'reviewable';
    }

    protected function belongsToKey(): string
    {
        return 'reviewed_by';
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reviewed_by' => User::factory(),
            'title' => fake()->sentence(),
            'review' => fake()->sentence(),
            'response' => fake()->sentence(),
            'rating' => fake()->randomElement(ReviewRating::cases()),
        ];
    }
}
