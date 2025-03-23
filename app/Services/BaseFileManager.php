<?php

namespace App\Services;

use SplFileInfo;
use Carbon\Carbon;
use Symfony\Component\Finder\Finder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\AwsS3V3Adapter;
use League\Flysystem\FilesystemException;

class BaseFileManager
{
    /**
     * Get disk list
     *
     * @return array
     */

    public function getDiskList(): array
    {
        return ['local', 'public', 's3'];
    }

    /**
     * Check disk name
     *
     * @param $name
     *
     * @return bool
     */
    public function checkDisk($name): bool
    {
        return in_array($name, $this->getDiskList())
            && array_key_exists($name, config('filesystems.disks'));
    }

    /**
     * Check Disk and Path
     *
     * @param $disk
     * @param $path
     *
     * @return bool
     */
    public function checkPath($disk, $path): bool
    {
        // check disk name
        if (!$this->checkDisk($disk)) {
            return false;
        }

        // check path
        if ($path && !Storage::disk($disk)->exists($path)) {
            return false;
        }

        return true;
    }

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
     * Get content for the selected disk and path
     *
     * @param $disk
     * @param $path
     *
     * @return array
     * @throws FilesystemException
     */
    public function getContent($disk, $path = null): array
    {
        $content = Storage::disk($disk)->listContents($path ?: '')->toArray();

        $directories = $this->filterDir($disk, $content);
        $files = $this->filterFile($disk, $content);

        return compact('directories', 'files');
    }

    /**
     * Get directories with properties
     *
     * @param $disk
     * @param $path
     *
     * @return array
     * @throws FilesystemException
     */
    public function directoriesWithProperties($disk, $path = null): array
    {
        $content = Storage::disk($disk)->listContents($path ?: '')->toArray();

        return $this->filterDir($disk, $content);
    }

    /**
     * Get files with properties
     *
     * @param       $disk
     * @param $path
     *
     * @return array
     * @throws FilesystemException
     */
    public function filesWithProperties($disk, $path = null): array
    {
        $content = Storage::disk($disk)->listContents($path ?: '');

        return $this->filterFile($disk, $content);
    }

    /**
     * Get directories for tree module
     *
     * @param $disk
     * @param $path
     *
     * @return array
     * @throws FilesystemException
     */
    public function getDirectoriesTree($disk, $path = null): array
    {
        $directories = $this->directoriesWithProperties($disk, $path);

        foreach ($directories as $index => $dir) {
            $directories[$index]['props'] = [
                'hasSubdirectories' => (bool) Storage::disk($disk)->directories($dir['path']),
            ];
        }

        return $directories;
    }

    /**
     * File properties
     *
     * @param $disk
     * @param $path
     *
     * @return mixed
     */
    public function fileProperties($disk, $path = null): mixed
    {
        $pathInfo = pathinfo($path);

        $properties = [
            'type'       => 'file',
            'path'       => $path,
            'basename'   => $pathInfo['basename'],
            'dirname'    => $pathInfo['dirname'] === '.' ? '' : $pathInfo['dirname'],
            'extension'  => $pathInfo['extension'] ?? '',
            'filename'   => $pathInfo['filename'],
            'size'       => Storage::disk($disk)->size($path),
            'timestamp'  => Storage::disk($disk)->lastModified($path),
            'visibility' => Storage::disk($disk)->getVisibility($path),
        ];

        return $properties;
    }

    /**
     * Get properties for the selected directory
     *
     * @param string $disk
     * @param string $path
     *
     * @return array|false
     */
    public function directoryProperties($disk, $path = null): array
    {
        $adapter = Storage::drive($disk)->getAdapter();

        $pathInfo = pathinfo($path);

        $properties = [
            'type'       => 'dir',
            'path'       => $path,
            'basename'   => $pathInfo['basename'],
            'dirname'    => $pathInfo['dirname'] === '.' ? '' : $pathInfo['dirname'],
            'timestamp'  => $adapter instanceof AwsS3V3Adapter ? null : Storage::disk($disk)->lastModified($path),
            'visibility' => $adapter instanceof AwsS3V3Adapter ? null : Storage::disk($disk)->getVisibility($path),
        ];

        return $properties;
    }

    /**
     * Get only directories
     *
     * @param $disk
     * @param $content
     *
     * @return array
     */
    protected function filterDir($disk, $content): array
    {
        // select only dir
        $dirsList = array_filter($content, fn($item) => $item['type'] === 'dir');

        $dirs = array_map(function ($item) {
            $pathInfo = pathinfo($item['path']);

            return [
                'type'       => $item['type'],
                'path'       => $item['path'],
                'basename'   => $pathInfo['basename'],
                'dirname'    => $pathInfo['dirname'] === '.' ? '' : $pathInfo['dirname'],
                'timestamp'  => $item['lastModified'],
                'visibility' => $item['visibility'],
            ];
        }, $dirsList);

        return array_values($dirs);
    }

    /**
     * Get only files
     *
     * @param $disk
     * @param $content
     *
     * @return array
     */
    protected function filterFile($disk, $content): array
    {
        // select only dir
        $filesList = array_filter($content, fn($item) => $item['type'] === 'file');

        $files = array_map(function ($item) {
            $pathInfo = pathinfo($item['path']);

            return [
                'type'       => $item['type'],
                'path'       => $item['path'],
                'basename'   => $pathInfo['basename'],
                'dirname'    => $pathInfo['dirname'] === '.' ? '' : $pathInfo['dirname'],
                'extension'  => $pathInfo['extension'] ?? '',
                'filename'   => $pathInfo['filename'],
                'size'       => $item['fileSize'],
                'timestamp'  => $item['lastModified'],
                'visibility' => $item['visibility'],
            ];
        }, $filesList);

        return array_values($files);
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

        $finder = new Finder();
        $finder->ignoreDotFiles(false)->depth('== 0')->in($path);

        $files = [];
        $directories = [];

        foreach ($finder as $file) {
            if ($file->isDir()) {
                $directories[] = $this->getFileInfo(new SplFileInfo($file), $pathReplace);
            } else {
                $files[] = $this->getFileInfo(new SplFileInfo($file), $pathReplace);
            }
        }

        $files = collect($files)->sortBy('name');
        $directories = collect($directories)->sortBy('name');

        return array_merge($directories->toArray(), $files->toArray());
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
}
