<?php

namespace App\Http\Controllers;

use App\Models\Blob;
use Illuminate\Http\Request;
use DraftScripts\FileManager\FilesystemUtils;

class HomeController extends Controller
{
    use FilesystemUtils;

    /**
     * @param Request $request
     * @return mixed
     */
    public function uploadBase64(Request $request)
    {
        $this->validate($request, [
            'file' => 'required',
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
        $content = $this->getContent('local');

        return response()->json($content);
    }
}
