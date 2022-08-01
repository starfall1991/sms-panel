<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'mobile' => fake()->numberBetween(100000000, 999999999999),
        ];
    }
}
