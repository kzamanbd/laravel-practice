<?php

namespace App\Http\Controllers;

use App\Services\BaseFileManager;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class FileManagerController
{
    public function __construct(public BaseFileManager $baseFileManager) {}

    public function index()
    {
        $basePath = base_path();
        $relativePath = request('path', ''); // Defaults to empty string if not provided
        $currentPath = base_path($relativePath);

        $files = $this->baseFileManager->getLocalDirectoryTree($currentPath, $basePath);
        $props = [
            'files' => $files,
            'path'  => str_replace($basePath, '', $currentPath),
        ];

        if (request()->expectsJson()) {
            return response()->json($props);
        }
        return Inertia::render('files/FileManager', $props);
    }

    public function content()
    {
        $contents = File::get(base_path(request('path')));
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
