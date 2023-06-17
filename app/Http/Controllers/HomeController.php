<?php

namespace App\Http\Controllers;

use App\Mail\AccountVerification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * @return RedirectResponse
     */
    function sendAccountVerificationMail(): RedirectResponse
    {
        $users = User::query()->limit(5)->get();
        foreach ($users as $user) {
            Mail::to($user->email)->queue(new AccountVerification($user));
        }
        return back()->with('success', 'Notification successfully send.');
    }
}
