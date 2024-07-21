<?php

namespace DraftScripts\Messaging\Http\Controllers;

use DraftScripts\Messaging\Http\Helpers\Helpers;
use DraftScripts\Messaging\Models\Conversation;
use DraftScripts\Messaging\Models\Message;
use DraftScripts\Messaging\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MessagingController extends Controller
{

    public function currentUser()
    {
        $conversations = Conversation::query()
            ->with(['participant'])
            ->whereAny(['from_user_id', 'to_user_id'], auth()->id())
            ->orderBy('updated_at', 'desc')
            ->get();

        $ids = collect(array_merge(
            $conversations->pluck('from_user_id')->toArray(),
            $conversations->pluck('to_user_id')->toArray()
        ))->unique();

        $users = User::query()->whereNotIn('id', $ids)->get();
        $currentUser = User::find(auth()->id());

        return response()->json([
            'success' => true,
            'user' => $currentUser,
            'users' => $users,
            'conversations' => $conversations,
        ]);
    }

    public function getMessages(Request $request)
    {
        $uuid = $request->input('uuid');


        if ($uuid) {
            $conversation = Conversation::query()
                ->with(['participant', 'messages:id,conversation_id,user_id,msg_type,message,created_at', 'messages.user:id,name'])
                ->where('uuid', $uuid)
                ->first();

            return response()->json([
                'success' => true,
                'conversation' => $conversation
            ]);
        }
        return response()->json([
            'success' => false,
            'conversation' => (object)[]
        ], 404);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $text = $request->input('message');
            $conversationId = $request->input('conversation_id');
            $conversation = null;
            if (!$conversationId) {
                $conversation = Conversation::createOrFirst([
                    'from_user_id' => auth()->id(),
                    'to_user_id' => $request->input('to_user_id')
                ], [
                    'uuid' => Str::uuid()
                ]);
                $conversationId = $conversation->id;
            }

            $text = preg_replace(Helpers::LINK_REGEX, Helpers::LINK_REPLACE, $text);
            $text = preg_replace(Helpers::EMAIL_REGEX, Helpers::EMAIL_REPLACE, $text);
            $text = preg_replace(Helpers::PHONE_REGEX, Helpers::PHONE_REPLACE, $text);

            $message = Message::create([
                'conversation_id' => $conversationId,
                'user_id' => auth()->id(),
                'message' => $text
            ]);

            Conversation::find($conversationId)->update([
                'last_msg_id' => $message->id,
                'updated_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => $message->load('user'),
                'conversation' => $conversation
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
