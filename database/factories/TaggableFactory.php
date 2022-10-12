<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Taggable;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaggableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'tag_id' => Tag::query()->inRandomOrder()->first(),
            'taggable_id' => Post::query()->inRandomOrder()->first(),
            'taggable_type' => 'App\Models\Post',
        ];
    }
}
