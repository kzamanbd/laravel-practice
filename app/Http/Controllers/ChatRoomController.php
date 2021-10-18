<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class ChatRoomController extends Controller
{
    public function index(){

        $users = Cache::get('users', function(){
            return User::with(['roles'])->latest()->limit(50)->get();
        });
        return Inertia::render('Chat/Chat', [
            'users' => $users
        ]);
    }

    public function rooms(){
        return ChatRoom::all();
    }

    public function messages(Request $request, $roomId){
        return ChatMessage::query()
            ->where('chat_room_id', $roomId)
            ->with('user')
            ->orderByDesc('created_at')
            ->get();
    }

    public function newMessages(Request $request, $roomId){
        $message = new ChatMessage();
        $message->chat_room_id = $roomId;
        $message->user_id = Auth::id();
        $message->message = $request->message;
        $message->save();

        broadcast(new NewChatMessage($message))->toOthers();
        
        return $message;
    }
}
