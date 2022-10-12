<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'from_user_id' => User::query()->inRandomOrder()->first(),
            'to_user_id' => User::query()->inRandomOrder()->first(),
            'message' => fake()->sentence
        ];
    }
}
