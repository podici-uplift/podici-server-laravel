<?php

namespace Database\Factories;

use App\Models\User;
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
    use HasProductMorph;
    use HasShopMorph;
    use HasUserMorph;
    use HasMediaMorph;

    protected function getMorphNameBase(): string
    {
        return 'likeable';
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
        ];
    }
}
