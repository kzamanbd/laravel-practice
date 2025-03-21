<?php

namespace App\Http\Controllers;

use App\Enums\AppContainsEnum;
use App\Http\Helpers;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class MessagingController
{
    public function initialize(Request $request, $uuid = null)
    {
        $conversations = Conversation::query()
            ->with(['participant'])
            ->whereAny(['author_id', 'to_user_id'], Auth::id())
            ->where('msg_type', AppContainsEnum::SINGLE_MSG)
            ->orderBy('updated_at', 'desc')
            ->get();

        $groups = Conversation::query()
            ->whereIn(
                'id',
                DB::table('message_group_user')
                    ->where('user_id', Auth::id())
                    ->distinct('conversation_id')
                    ->pluck('conversation_id')->toArray()
            )->get();

        $users = User::query()->whereNot('id', Auth::id())->get();

        if ($uuid) {
            $conversation = Conversation::query()
                ->with(['participant', 'messages:id,conversation_id,user_id,msg_type,message,created_at', 'messages.user:id,name'])
                ->where('uuid', $uuid)
                ->first();
        } else {
            $conversation = null;
        }

        return Inertia::render('messaging/MessagesView', [
            'users' => $users,
            'groups' => $groups,
            'conversations' => $conversations,
            'conversation' => $conversation
        ]);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $text = $request->input('message');
            $conversationId = $request->input('conversation_id');
            $conversation = null;
            if (!$conversationId) {
                // check already has create a conversation
                $conversation = Conversation::query()->where([
                    'author_id' => Auth::id(),
                    'to_user_id' => $request->input('to_user_id')
                ])->orWhere([
                    'author_id' => $request->input('to_user_id'),
                    'to_user_id' => Auth::id()
                ])->firstOrCreate([
                    'author_id' => Auth::id(),
                    'to_user_id' => $request->input('to_user_id'),
                    'uuid' => Str::uuid()
                ]);

                $conversationId = $conversation->id;
            }

            $text = preg_replace(Helpers::LINK_REGEX, Helpers::LINK_REPLACE, $text);
            $text = preg_replace(Helpers::EMAIL_REGEX, Helpers::EMAIL_REPLACE, $text);
            $text = preg_replace(Helpers::PHONE_REGEX, Helpers::PHONE_REPLACE, $text);

            $message = Message::create([
                'conversation_id' => $conversationId,
                'user_id' => Auth::id(),
                'message' => $text
            ]);

            Conversation::find($conversationId)->update([
                'last_msg_id' => $message->id,
                'updated_at' => now()
            ]);

            if ($conversation) {
                $conversation = $conversation->load([
                    'participant',
                    'messages:id,conversation_id,user_id,msg_type,message,created_at',
                    'messages.user:id,name'
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
        return to_route('messaging', $conversation->uuid);
    }


    public function createGroup(Request $request)
    {
        DB::beginTransaction();
        try {

            $groupMembers = $request->input('group_members');
            $groupName = $request->input('group_name') ?? Auth::user()->name . " and others " . count($groupMembers);
            $conversation = Conversation::create([
                'title' => $groupName,
                'author_id' => Auth::id(),
                'uuid' => Str::uuid()
            ]);

            $groupData = [];
            foreach ($groupMembers as $id) {
                $groupData[] = [
                    'conversation_id' => $conversation->id,
                    'user_id' => $id,
                    'created_by' => Auth::id()
                ];
            }
            DB::table('message_group_user')->insert($groupData);

            // $conversation->groups->attach($groupMembers);

            return response()->json([
                'success' => true,
                'message' => 'Group Successfully Created.',
                'conversation' => $conversation,
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
