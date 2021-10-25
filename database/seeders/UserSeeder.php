<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $total_users = 1453;
        $admin_email = 'laravel@practice.test';

        $defined_emails = [
            $admin_email
        ];

        foreach ($defined_emails as $email) {
            if (User::whereEmail($email)->first()){
                continue;
            }

            if ($email === $admin_email){
                User::factory()->create(['email' => $email]);
            }

            $total_users--;
        }

        User::factory($total_users)->create();
    }
}
