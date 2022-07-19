<?php

namespace Database\Factories;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Taggable;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaggableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Taggable::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tag_id' => Tag::all()->pluck('id')->random(),
            'taggable_id' => Post::all()->pluck('id')->random(),
            'taggable_type' => 'App\Models\Post',
        ];
    }
}
