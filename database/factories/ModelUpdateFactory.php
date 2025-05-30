<?php

namespace Database\Factories;

use App\Models\User;
use Database\Factories\Traits\Morph\HasProductMorph;
use Database\Factories\Traits\Morph\HasShopMorph;
use Database\Factories\Traits\Morph\HasUserMorph;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ModelUpdate>
 */
class ModelUpdateFactory extends Factory
{
    use HasProductMorph;
    use HasShopMorph;
    use HasUserMorph;

    protected function getMorphNameBase(): string
    {
        return 'updatable';
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'updated_by' => User::factory(),
            'field' => fake()->word(),
        ];
    }

    public function field(string $field): static
    {
        return $this->state(fn (array $attributes) => ['field' => $field]);
    }

    public function withValues(?mixed $oldValue = null, mixed $newValue = null): static
    {
        return $this->state(fn (array $attributes) => [
            'old_value' => $oldValue ?? fake()->word(),
            'new_value' => $newValue ?? fake()->word(),
        ]);
    }
}
