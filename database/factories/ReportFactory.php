<?php

namespace Database\Factories;

use App\Enums\Report\ReportStatus;
use App\Enums\Report\ReportType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
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
            'type' => fake()->randomElement(ReportType::cases()),
            'title' => fake()->realText(24),
            'reason' => fake()->realText(256),
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
                'resolution_note' => fake()->realText(256),
                'resolved_by' => User::factory(),
            ];
        });
    }
}
