<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = config('menus.available');

        // total count
        foreach ($menus as $slug => $menu) {
            Menu::create([
                'name' => $menu['name'],
                'slug' => $slug
            ]);
        }
    }
}
