<?php

namespace DraftScripts\FileManager\Http\Controllers;

use Carbon\Carbon;
use FilesystemIterator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

class FileManagerController
{
    /**
     * Helper function to format file sizes into readable format
     *
     * @param $bytes int
     *
     * @return string
     */
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = '1 byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    /**
     * Helper function to get the file or directory info
     *
     * @param $item SplFileInfo object
     *
     * @return object
     */

    function getFileInfo(SplFileInfo $item, $pathReplace = null)
    {
        $modifiedItem = [
            'type' => $item->getType(),
            'name' => $item->getFilename(),
            'path' => $item->getPathname(),
            'size' => $this->formatSizeUnits($item->getSize()),
            'modified_at' => Carbon::createFromTimestamp($item->getMTime())->toDateTimeString(),
        ];

        if ($item->getType() == 'dir') {
            $modifiedItem['type'] = 'directory';
            $modifiedItem['size'] = $this->formatSizeUnits($this->getDirectorySize($item->getPathname()));
            $modifiedItem['expanded'] = false;
            $modifiedItem['children'] = [];
        }

        if ($pathReplace) {
            $modifiedItem['path'] = str_replace($pathReplace, '', $modifiedItem['path']);
        }

        return $modifiedItem;
    }

    /**
     * Helper function to get the size of a directory
     *
     * @param $path
     *
     * @return int
     */

    function getDirectorySize($path)
    {
        if (!is_dir($path)) {
            return filesize($path);
        }

        $bytes = 0;

        // get current operation system info
        $os = php_uname('s');
        // if os is unix based or macOS then use the du command
        if ($os == 'Darwin' || $os == 'Linux') {
            $bytes = shell_exec("du -sb $path | awk '{print $1}'");
            return $bytes;
        }

        $path = realpath($path);

        if ($path !== false) {
            $directory = new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS);
            foreach (new RecursiveIteratorIterator($directory) as $object) {
                $bytes += $object->getSize();
            }
        }

        return $bytes;
    }

    /**
     * Function to recursively build the directory tree
     *
     * @param $path The path to the directory string
     * @param $pathReplace Replace the path with this string
     *
     * @return array
     */
    function getLocalDirectoryTree($path, $pathReplace = null)
    {
        $items = [];

        // Get all directories in the current directory
        foreach (File::directories($path) as $dir) {
            $items[] = $this->getFileInfo(new SplFileInfo($dir), $pathReplace);
        }

        // Get all files in the current directory
        foreach (File::files($path) as $file) {
            $items[] = $this->getFileInfo(new SplFileInfo($file), $pathReplace);
        }

        return $items;
    }


    /**
     * Get Remote Directory Tree (S3, FTP, etc)
     *
     * @param $path string
     *
     * @return array
     */

    function getRemoteDirectoryTree($path, string $disk = 'local')
    {
        // Implement your remote directory tree logic here

        $items = [];
        // type is local or remote

        // Get all directories in the current directory
        $directories = Storage::disk($disk)->directories($path);

        foreach ($directories as $dir) {
            $directoryInfo = new SplFileInfo($dir);
            $items[] = [
                'type' => 'directory',
                'name' => $directoryInfo->getFilename(),
                'path' => $directoryInfo->getPathname(),
                'size' => Storage::disk($disk)->size($dir),
                'modified_at' => Carbon::createFromTimestamp(0)->toDateTimeString(),
                'expanded' => false,
                'children' => [] // $this->getRemoteDirectoryTree($dir), // Recursive call
            ];
        }

        // Get all files in the current directory
        $files = Storage::disk($disk)->files($path);

        foreach ($files as $file) {
            $fileInfo = new SplFileInfo($file);
            $items[] = [
                'type' => 'file',
                'name' => $fileInfo->getFilename(),
                'path' => $fileInfo->getPathname(),
                'size' => $this->formatSizeUnits(Storage::disk($disk)->size($file)),
                'modified_at' => Carbon::createFromTimestamp(Storage::disk($disk)->lastModified($file))->toDateTimeString(),
            ];
        }

        return $items;
    }

    /**
     * Function to get the directory tree
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function index()
    {
        if (request()->has('disk') && !empty(request('disk'))) {
            $disk = request('disk');
            $currentPath = request('path') ?? '/';
            $files = $this->getRemoteDirectoryTree($currentPath, $disk);
            return response()->json([
                'files' => $files
            ]);
        }

        $currentPath = base_path(); // Start with base path or provided initial path
        if (request()->has('path')) {
            $currentPath = base_path(request('path'));
        }
        $files = $this->getLocalDirectoryTree($currentPath, base_path());
        return response()->json([
            'files' => $files,
            'currentPath' => $currentPath
        ]);
    }
}
