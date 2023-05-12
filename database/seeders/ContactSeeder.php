<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            self::contactSeeder();
        }
    }

    public function contactSeeder()
    {
        $json_path = public_path('docs/contacts.json');

        $contacts = collect(json_decode(file_get_contents($json_path), true));

        // set max progress
        $this->command->getOutput()->progressStart($contacts->count());

        // add timestamps
        $contacts = $contacts->map(function ($contact) {
            $contact['created_at'] = now();
            $contact['updated_at'] = now();
            // progress
            $this->command->getOutput()->progressAdvance();
            return $contact;
        })->toArray();

        // insert into database
        Contact::insert($contacts);
        // finish progress
        $this->command->getOutput()->progressFinish();
    }
}
