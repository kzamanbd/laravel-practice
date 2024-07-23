<?php

namespace DraftScripts\Messaging\Http\Helpers;

use Carbon\Carbon;

class Helpers
{
    const LINK_REGEX = '/(https?:\/\/[^\s]+)/';
    const LINK_REPLACE = '<a href="$1" target="_blank">$1</a>';
    const EMAIL_REGEX = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/';
    const EMAIL_REPLACE = '<a href="mailto:$0" target="_blank">$0</a>';
    const PHONE_REGEX = '/\+?(88)?0?1[3456789][0-9]{8}\b/';
    const PHONE_REPLACE = '<a href="tel:$0" target="_blank">$0</a>';

    public static function getLastActiveAt(int $key)
    {
        $sessionKey = "last_active_at" . $key;
        if (cache($sessionKey)) {
            if (Carbon::parse(cache($sessionKey))->diffInMinutes() > 1) {
                return 'Active';
            }
            return Carbon::parse(cache($sessionKey))->diffForHumans();
        } else {
            return 'Offline';
        }
    }
}
