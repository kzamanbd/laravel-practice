<?php

namespace App\Http\Controllers;

use App\Mail\AccountVerification;
use App\Models\Blob;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function sendAccountVerificationMail(): RedirectResponse
    {
        $users = User::query()->limit(5)->get();
        foreach ($users as $user) {
            Mail::to($user->email)->queue(new AccountVerification($user));
        }

        return back()->with('success', 'Notification successfully send.');
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
            return redirect()->back()->with('success', 'File uploaded successfully.');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
