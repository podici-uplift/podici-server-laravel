<?php

namespace Database\Factories;

use App\Models\User;
use Database\Factories\Traits\HasBelongsTo;
use Database\Factories\Traits\Morph\HasMediaMorph;
use Database\Factories\Traits\Morph\HasProductMorph;
use Database\Factories\Traits\Morph\HasShopMorph;
use Database\Factories\Traits\Morph\HasUserMorph;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    use HasMediaMorph;
    use HasProductMorph;
    use HasShopMorph;
    use HasUserMorph;
    use HasBelongsTo;

    protected function getMorphNameBase(): string
    {
        return 'likeable';
    }

    protected function belongsToKey(): string
    {
        return 'liked_by';
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'liked_by' => User::factory(),
        ];
    }
}
