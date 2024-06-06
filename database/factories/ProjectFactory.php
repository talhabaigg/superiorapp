<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'project_name' => $this->faker->words(3, true),
            'abbreviated_project_name' => $this->faker->word,
            'subsidiary' => $this->faker->randomElement(['Superior Walls & Ceilings', 'Greenline']),
            'project_number' => $this->faker->unique()->numerify('PRJ####'),
            'description' => $this->faker->sentence,
            'notes' => $this->faker->paragraph,
            'timezone' => $this->faker->timezone,
            'average_hourly_rate' => $this->faker->randomFloat(2, 10, 100),
            'estimated_hours' => $this->faker->numberBetween(100, 1000),
            'deadline' => $this->faker->dateTimeBetween('+1 week', '+1 year'),
            'completed' => $this->faker->boolean,
            'daily_qr_code' => $this->faker->boolean,
        ];
    }
}