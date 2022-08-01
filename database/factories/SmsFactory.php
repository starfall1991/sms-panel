<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SmsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'text'       => fake()->paragraph,
            'driver'     => fake()->randomElement(['sms']),
            'user_id'    => User::factory(),
            'done_at'    => null,
            'create_at'  => fake()->dateTime,
            'updated_at' => fake()->dateTime,
        ];
    }

    public function done(): SmsFactory
    {
        return $this->state(function (array $attributes) {
            return [
                'done_at' => now(),
            ];
        });
    }

    public function withUser(User $user): SmsFactory
    {
        return $this->state(function (array $attributes)use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }
}
