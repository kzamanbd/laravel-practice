<?php

namespace DraftScripts\FileManager\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'; // password

        User::forceCreate([
            'name' => 'Laravel FileManager',
            'email' => 'files@laravel.com',
            'password' => $password,
        ]);
    }
}
