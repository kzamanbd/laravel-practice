<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'android_title' => $this->faker->word(),
            'transaction_id' => $this->faker->word(),
            'android_text' => $this->faker->text(),
            'msg_from' => $this->faker->word(),
            'sender' => $this->faker->word(),
            'is_offline' => $this->faker->randomNumber(),
            'status' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
