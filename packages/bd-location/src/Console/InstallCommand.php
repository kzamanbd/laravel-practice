<?php

namespace DraftScripts\BdLocation\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'location:install')]
class InstallCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Location controllers and resources';

    /**
     * Execute the console command.
     *
     * @return int|null
     */
    public function handle()
    {
       $this->info('Example command executed successfully!');

        return 0;
    }
}
