<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $features = File::json(database_path('features.json'));

        $features = collect($features['data']);
        // set max progress
        $this->command->getOutput()->progressStart($features->count());

        // add timestamps
        $features = $features->map(function ($feature) {
            $feature['created_at'] = now();
            $feature['updated_at'] = now();
            $feature['slug'] = $feature['slug'] ?? Str::slug($feature['name']);
            // progress
            $this->command->getOutput()->progressAdvance();
            return $feature;
        })->toArray();

        // insert into database
        Feature::insert($features);
        // finish progress
        $this->command->getOutput()->progressFinish();
    }
}
