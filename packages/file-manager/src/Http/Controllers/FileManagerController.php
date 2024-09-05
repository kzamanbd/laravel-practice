<?php

namespace DraftScripts\FileManager\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FileManagerController
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
                'path' => str_replace(base_path(), '', $directoryInfo->getPathname()),
                'size' => $directoryInfo->getSize(),
                'last_modified' => $directoryInfo->getMTime(),
                'children' => [] // $this->getDirectoryTree($dir), // Recursive call
            ];
        }

        // Get all files in the current directory
        foreach (File::files($directory) as $file) {
            $items[] = [
                'type' => 'file',
                'name' => $file->getFilename(),
                'path' => str_replace(base_path(), '', $file->getPathname()),
                'size' => $file->getSize(),
                'last_modified' => Carbon::createFromTimestamp($file->getMTime())->toDateTimeString(),
            ];
        }

        return $items;
    }

    public function index()
    {
        $currentPath = base_path(); // Start with base path or provided initial path
        if (request()->has('path')) {
            $currentPath = base_path(request('path'));
        }
        $files = $this->getDirectoryTree($currentPath);
        return response()->json([
            'files' => $files,
            'currentPath' => $currentPath
        ]);
    }
}
