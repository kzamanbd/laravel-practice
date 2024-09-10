<?php

namespace App\Http\Controllers;

use App\Models\Blob;
use DraftScripts\FileManager\FilesystemUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    use FilesystemUtils;
    public function uploadBase64(Request $request)
    {
        $this->validate($request, [
            'file' => 'required'
        ]);
        try {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $fileData = file_get_contents($file->getRealPath());

            $blob = new Blob();
            $blob->filename = $filename;
            $blob->file_data = $fileData;
            $blob->save();
            return redirect()->back()->with('success', 'File uploaded successfully.');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function remoteFiles()
    {
        $content  = $this->getContent('local');

        return response()->json($content);
    }
}