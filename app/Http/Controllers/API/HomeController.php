<?php

namespace App\Http\Controllers\API;

use App\Models\Blob;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Throwable;

class HomeController extends Controller
{
    public function initApp()
    {
        $users = User::latest()->limit(20)->get();
        $tags = Tag::latest()->limit(20)->get();

        return response()->json([
            'success' => true,
            'users' => $users,
            'tags' => $tags,
        ], 200);
    }

    public function user($id)
    {
        $user = User::find($id);

        return response()->json([
            'success' => true,
            'user' => $user,
        ], 200);
    }

    public function uploadImage(Request $request)
    {
        $png_url = uniqid() . time() . '.jpg';
        $path = 'images/' . $png_url;
        $img = file_get_contents($request->image);
        $success = Storage::put($path, $img);
        echo $success ? $png_url : 'Unable to save the file.';
    }

    public function uploadDocsFile(Request $request)
    {
        $uploaded_file = [];
        foreach ($request->attachments as $attachment) {
            $type = explode('.', $attachment['name']);
            $file_name = uniqid() . time() . '.' . end($type);
            $path = 'docs/' . $file_name;
            $base64 = file_get_contents($attachment['base64']);
            Storage::put($path, $base64);
            $uploaded_file[] = $file_name;
        }

        return $uploaded_file;
    }

    public function getAllUsers()
    {
        $users = User::with('roles')->latest()->limit(50)->get();

        return response()->json([
            'success' => true,
            'users' => $users,
        ], 200);
    }

    public function testDatabaseTransactions()
    {

        DB::beginTransaction(function () {
            $category = Category::query()->create([
                'name' => 'Test Category',
                'slug' => 'test-category',
            ]);
            $user = User::query()->create([
                'name' => 'ZAMAN',
                'email' => 'zaman@gmail.com',
                'password' => bcrypt('password'),
            ]);

            DB::commit();

            return [$user, $category];
        }, 5);

        return response()->json([
            'success' => true,
            'message' => 'Database transaction success',
        ], 200);
    }
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
            return $blob->id;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
