<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get values from the user
        $name = $this->ask('What is your name?');
        $email = $this->ask('What is your email?');
        $password = $this->secret('What is your password?');


        // create the user
        $user = [
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
        ];

        dd($user);
    }
}
