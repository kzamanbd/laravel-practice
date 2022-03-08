<?php

namespace App\Http\Controllers;

use App\Mail\UserAccountVerificationMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * @return RedirectResponse
     */
    function sendAccountVerificationMail()
    {

        $users = User::query()->limit(5)->get();
        foreach ($users as $user) {
            Mail::to($user->email)->queue(new UserAccountVerificationMail($user));
        }
        return back()->with('success', 'Notification successfully send.');
    }

    public function profile()
    {
        return view('user-profile');
    }
}
