<?php

namespace App\Http\Controllers;

use SplFileInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class FileManagerController
{
    /**
     * Helper function to format file sizes into readable format
     *
     * @param $bytes int
     *
     * @return string
     */
    public function formatSizeUnits($bytes)
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
            $bytes = 'N/A';
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

    public function getFileInfo(SplFileInfo $item, $pathReplace = null)
    {
        $modifiedItem = [
            'type'        => $item->getType(),
            'name'        => $item->getFilename(),
            'path'        => $item->getPathname(),
            'size'        => $this->formatSizeUnits($item->getSize()),
            'modified_at' => Carbon::createFromTimestamp($item->getMTime())->toDateTimeString(),
        ];

        if ($item->getType() == 'dir') {
            $modifiedItem['type'] = 'directory';
            $modifiedItem['size'] = $this->formatSizeUnits($this->getDirectorySize($item->getPathname()));
            $modifiedItem['expanded'] = false;
            $modifiedItem['children'] = []; // $this->getRemoteDirectoryTree($dir), // Recursive call to get the children
        }

        if ($pathReplace) {
            $modifiedItem['path'] = str_replace($pathReplace, '', $modifiedItem['path']);
        }

        return (object) $modifiedItem;
    }

    /**
     * Helper function to get the size of a directory
     *
     * @param $path
     *
     * @return int
     */

    public function getDirectorySize($path)
    {

        if (!is_dir($path)) {
            return filesize($path);
        }

        // if os is unix based or macOS then use the du command
        if (PHP_OS_FAMILY == 'Darwin' || PHP_OS_FAMILY == 'Linux') {
            $bytes = shell_exec("du -sb $path | awk '{print $1}'");
            return $bytes;
        }

        return 0;
    }

    /**
     * Function to recursively build the directory tree
     *
     * @param $path The path to the directory string
     * @param $pathReplace Replace the path with this string
     *
     * @return array
     */
    public function getLocalDirectoryTree($path, $pathReplace = null)
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

    public function getRemoteDirectoryTree($path, string $disk = 'local')
    {
        // Implement your remote directory tree logic here

        $items = [];
        // Get all directories in the current directory
        $directories = Storage::disk($disk)->directories($path);
        // Get all files in the current directory
        $files = Storage::disk($disk)->files($path);

        return $items;
    }

    public function index()
    {
        if (request()->has('disk') && !empty(request('disk'))) {
            $disk = request('disk');
            $currentPath = request('path') ?? '/';
            $files = $this->getRemoteDirectoryTree($currentPath, $disk);
            return response()->json([
                'files' => $files,
            ]);
        }

        $initialPath = base_path();

        $currentPath = $initialPath;

        // Start with base path or provided initial path
        if (request()->has('path')) {
            $currentPath = base_path(request('path'));
        }

        $files = $this->getLocalDirectoryTree($currentPath, $initialPath);

        if (request('path')) {
            return response()->json([
                'files' => $files,
                'path'  => str_replace($initialPath, '', $currentPath),
            ]);
        }
        return Inertia::render('files/FileManager', [
            'files' => $files,
            'path'  => str_replace($initialPath, '', $currentPath),
        ]);
    }

    public function content()
    {
        $path = request('path');

        if (request()->has('disk') && !empty(request('disk'))) {
            $disk = request('disk');
            $contents = Storage::disk($disk)->get($path);
            return response()->json([
                'contents' => $contents,
            ]);
        }

        $contents = File::get(base_path($path));
        return response()->json([
            'contents' => $contents,
        ]);
    }

    public function updateContent()
    {
        $path = request('path');
        $content = request('content');
        File::put(base_path($path), $content);
        return response()->json([
            'success' => true,
            'path' => $path
        ]);
    }
}
