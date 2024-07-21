<?php

namespace DraftScripts\Messaging\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = [
        'msg_group',
        'formatted_time'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'seen_at' => 'datetime',
        ];
    }

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class, 'conversation_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getMsgGroupAttribute(): string
    {
        $createdAt = $this->created_at;
        // get date week name
        $date = $createdAt->format('Y-m-d');
        $week = $createdAt->format('l');
        $time = $createdAt->format('h:i A');

        if ($date == date('Y-m-d')) {
            return 'Today';
        } else if ($date == date('Y-m-d', strtotime('-1 day'))) {
            return "Yesterday";
        } else if ($date > date('Y-m-d', strtotime('-1 week'))) {
            return "$week";
        }
        return $createdAt->format('d M Y');
    }

    public function getFormattedTimeAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
