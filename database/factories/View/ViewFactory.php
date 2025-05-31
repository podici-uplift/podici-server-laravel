<?php

namespace Database\Factories\View;

use App\Models\User;
use Database\Factories\Traits\HasBelongsTo;
use Database\Factories\Traits\Morph\HasProductMorph;
use Database\Factories\Traits\Morph\HasShopMorph;
use Database\Factories\Traits\Morph\HasUserMorph;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\View>
 */
class ViewFactory extends Factory
{
    use HasProductMorph;
    use HasShopMorph;
    use HasUserMorph;
    use HasBelongsTo;

    protected function getMorphNameBase(): string
    {
        return 'viewable';
    }

    protected function belongsToKey(): string
    {
        return 'viewed_by';
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'viewed_by' => User::factory(),
            'date' => now(),
        ];
    }

    public function viewDate(string $date): Factory
    {
        return $this->state(fn (array $attributes) => ['date' => $date]);
    }
}
