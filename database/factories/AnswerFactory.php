<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'questions_id' => '1',
            'socre' => 5,
            'Location' => 'test',
            'deviceAgent' => 'test'.fake()->userAgent(),
            'user' => fake()->userName(),
        ];
    }
}
