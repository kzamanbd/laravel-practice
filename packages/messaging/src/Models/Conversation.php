<?php

namespace DraftScripts\Messaging\Models;

use DraftScripts\Messaging\Http\Helpers\Helpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Conversation extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = [
        'msg_preview',
        'last_msg_at',
        'last_active_at'
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'conversation_id')
            ->orderBy('created_at');
    }

    public function participant(): HasOne
    {
        if ($this->to_user_id == auth()->id()) {
            return $this->hasOne(User::class, 'id', 'author_id');
        }
        return $this->hasOne(User::class, 'id', 'to_user_id');
    }

    public function getLastActiveAtAttribute()
    {
        $key = $this->to_user_id == auth()->id()
            ? $this->author_id
            : $this->to_user_id;
        if ($key) {
            return Helpers::getLastActiveAt($key);
        }
        return null;
    }

    public function lastMessage(): HasOne
    {
        return $this->hasOne(Message::class, 'id', 'last_msg_id');
    }

    public function getMsgPreviewAttribute(): string
    {
        $lastMessage = $this->lastMessage()->first();
        if ($lastMessage) {
            // remove html tags
            $message = strip_tags($lastMessage->message);
            if ($lastMessage->user_id == auth()->id()) {
                return "You: $message";
            }
            return $message;
        }
        return 'No message yet';
    }

    public function getLastMsgAtAttribute(): string
    {
        $updatedAt = $this->updated_at;
        if (!$updatedAt) {
            return '';
        }
        // get date week name
        $date = $updatedAt->format('Y-m-d');
        $week = $updatedAt->format('l');
        $time = $updatedAt->format('h:i A');

        if ($date == date('Y-m-d')) {
            return $time;
        } else if ($date == date('Y-m-d', strtotime('-1 day'))) {
            return "Yesterday $time";
        } else if ($date > date('Y-m-d', strtotime('-1 week'))) {
            return "$week $time";
        }
        return $updatedAt->format('d M Y');
    }
}
