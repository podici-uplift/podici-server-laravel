<?php

namespace Database\Factories;

use App\Enums\Report\ReportStatus;
use App\Enums\Report\ReportType;
use App\Models\User;
use Database\Factories\Traits\Morph\HasMediaMorph;
use Database\Factories\Traits\Morph\HasProductMorph;
use Database\Factories\Traits\Morph\HasShopMorph;
use Database\Factories\Traits\Morph\HasUserMorph;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    use HasMediaMorph;
    use HasProductMorph;
    use HasShopMorph;
    use HasUserMorph;

    protected function getMorphNameBase(): string
    {
        return 'reportable';
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reported_by' => User::factory(),
            'type' => fake()->randomElement(ReportType::cases()),
            'title' => fake()->sentence(),
            'reason' => fake()->sentence(),
            'status' => fake()->randomElement(ReportStatus::cases()),
        ];
    }

    public function pending(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => ReportStatus::PENDING,
            ];
        });
    }

    public function resolved(ReportStatus $status = ReportStatus::RESOLVED)
    {
        return $this->state(function (array $attributes) use ($status) {
            return [
                'status' => $status,
                'resolved_at' => now(),
                'resolution_note' => fake()->sentence(),
                'resolved_by' => User::factory(),
            ];
        });
    }
}
