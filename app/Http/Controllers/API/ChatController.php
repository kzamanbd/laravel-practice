<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getMessage(Request $request){

        $user =  User::where('username', $request->to_user)->first();
        $chats = Chat::where('to_user_id', $user->id)->where('from_user_id', $request->from_user_id)->get();
        return response()->json([
            'user' => $user,
            'chats' => $chats
        ]);
    }
}
