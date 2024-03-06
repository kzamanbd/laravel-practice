<?php

namespace App\Http\Controllers;

use App\Models\Blob;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function uploadBase64(Request $request)
    {
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
}
