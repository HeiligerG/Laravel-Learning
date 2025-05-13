<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TweetFactory extends Factory
{
    public function definition(): array
    {
        return [
            'text' => fake()->words(rand(3, 25), true),
            'likes' => $this->faker->numberBetween(0, 5000),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }
}
