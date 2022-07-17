<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->jobTitle . $this->faker->jobTitle,
            'slug' => $this->faker->slug,
            'category_id' => Category::all()->pluck('id')->random(),
            'user_id' => User::all()->pluck('id')->random(),
            'body' => $this->faker->realText . $this->faker->realText,
            'image' => $this->faker->imageUrl($width = 700, $height = 300)
        ];
    }
}
