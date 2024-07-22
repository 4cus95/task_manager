<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timer>
 */
class TimerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startedAt = $this->faker->dateTimeBetween('-6 hours', 'now');
        $endedAt = $this->faker->dateTimeBetween($startedAt, '+6 hours');

        return  [
            'task_id' => 0,
            'user_id' => 0,
            'started_at' => $startedAt,
            'ended_at' => $endedAt,
        ];
    }
}
