<?php

use Carbon\Carbon;

function translate($key, $replace = [])
{
    return __($key, $replace);
}


function getLastActiveAt(int $key)
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
