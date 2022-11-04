<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Taggable::factory(20)->create();
    }
}
