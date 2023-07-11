<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateViewCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view {filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new blade file';

    public function createFile($fileName)
    {

        // if file already exists, don't create it throw an message
        if (file_exists(resource_path('views/' . $fileName . '.blade.php'))) {
            throw new \Exception('File already exists');
        }

        // if $fileName contains a slash, create the directory
        if (strpos($fileName, '/') !== false) {
            $fileNameParts = explode('/', $fileName);
            $fileName = array_pop($fileNameParts);
            $directory = implode('/', $fileNameParts);

            if (!is_dir(resource_path('views/' . $directory))) {
                mkdir(resource_path('views/' . $directory), 0777, true);
            }
        }

        if (!isset($directory)) {
            $fullPathWithDirectory = resource_path('views/' . $fileName . '.blade.php');
        } else {
            $fullPathWithDirectory = resource_path('views/' . $directory . '/' . $fileName . '.blade.php');
        }


        // create the file
        $file = fopen($fullPathWithDirectory, 'w');

        // write the content to the blade file
        fwrite($file, '<div>
    <h1>Hello World</h1>
</div>');

        // close the blade file
        fclose($file);
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // get the name of the blade file
        $fileName = $this->argument('filename');

        // create the blade file
        $this->createFile($fileName);
    }
}
