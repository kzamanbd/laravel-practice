<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ContactFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'mobile' => $this->faker->word(),
            'address' => $this->faker->address(),
            'e_tin' => $this->faker->word(),
            'old_tin' => $this->faker->word(),
            'tin_date' => $this->faker->word(),
            'police_station' => $this->faker->word(),
            'circle_name' => $this->faker->name(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
