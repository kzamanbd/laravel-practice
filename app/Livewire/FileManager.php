<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class FileManager extends Component
{
    // Function to recursively build the directory tree
    function getDirectoryTree($directory)
    {
        $items = [];

        // Get all directories in the current directory
        foreach (File::directories($directory) as $dir) {
            $directoryInfo = new \SplFileInfo($dir);
            $items[] = [
                'type' => 'directory',
                'name' => $directoryInfo->getFilename(),
                'path' => $directoryInfo->getPathname(),
                'size' => $directoryInfo->getSize(),
                'last_modified' => $directoryInfo->getMTime(),
                'children' => $this->getDirectoryTree($dir), // Recursive call
            ];
        }

        // Get all files in the current directory
        foreach (File::files($directory) as $file) {
            $items[] = [
                'type' => 'file',
                'name' => $file->getFilename(),
                'path' => $file->getPathname(),
                'size' => $file->getSize(),
                'last_modified' => Carbon::createFromTimestamp($file->getMTime())->toDateTimeString(),
            ];
        }

        return $items;
    }
    public function getFilesProperty()
    {
        return $this->getDirectoryTree(base_path());
    }

    public function render()
    {
        return view('livewire.file-manager');
    }
}
