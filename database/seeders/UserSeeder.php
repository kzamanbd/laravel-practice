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
        $total_users = 1000;
        $admin_email = 'kzamanbn@gmail.com';

        $defined_emails = [
            $admin_email
        ];

        foreach ($defined_emails as $email) {
            if (User::whereEmail($email)->first()) {
                continue;
            }

            if ($email === $admin_email) {
                User::factory()->create(['email' => $email]);
            }

            $total_users--;
        }

        User::factory($total_users)->create();
    }
}
