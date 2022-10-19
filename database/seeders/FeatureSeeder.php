<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $features = config('features.available');

        // total count
        foreach ($features as $slug => $feature) {
            Feature::create([
                'name' => $feature['name'],
                'slug' => $slug
            ]);
        }
    }
}
