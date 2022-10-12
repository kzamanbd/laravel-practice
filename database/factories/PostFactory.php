<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->jobTitle,
            'slug' => fake()->slug,
            'category_id' => Category::query()->inRandomOrder()->first(),
            'user_id' => User::query()->inRandomOrder()->first(),
            'body' => fake()->realText(1000),
            'image' => fake()->imageUrl($width = 700, $height = 300)
        ];
    }
}
