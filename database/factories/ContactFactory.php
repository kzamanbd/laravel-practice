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
            'mobile' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'e_tin' => strtoupper(substr(uniqid() . uniqid(), 0, 12)),
            'old_tin' => strtoupper(substr(uniqid() . uniqid(), 0, 12)),
            'tin_date' => $this->faker->date(),
            'police_station' => $this->faker->address(),
            'circle_name' => $this->faker->address(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
