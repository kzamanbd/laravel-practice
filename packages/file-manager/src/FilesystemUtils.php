<?php

namespace DraftScripts\FileManager;

use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\AwsS3V3Adapter;
use League\Flysystem\FilesystemException;

trait FilesystemUtils
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
     * Disk/path not found message
     *
     * @return array
     */
    public function notFoundMessage(): array
    {
        return [
            'result' => [
                'status'  => 'danger',
                'message' => 'notFound',
            ],
        ];
    }

    /**
     * Get content for the selected disk and path
     *
     * @param $disk
     * @param  null  $path
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
     * @param  null  $path
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
     * @param  null  $path
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
     * @param  null  $path
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
}