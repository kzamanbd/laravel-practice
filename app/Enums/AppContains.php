<?php

namespace App\Enums;

enum AppContains: string
{
    // religion code key for code elements
    public const RELIGION_CODE_KEY = 'RELIGION';

    public const GROUP_MSG = 'group';
    public const SINGLE_MSG = 'single';

    public const LINK_REGEX = '/(https?:\/\/[^\s]+)/';
    public const LINK_REPLACE = '<a href="$1" target="_blank">$1</a>';
    public const EMAIL_REGEX = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/';
    public const EMAIL_REPLACE = '<a href="mailto:$0" target="_blank">$0</a>';
    public const PHONE_REGEX = '/\+?(88)?0?1[3456789][0-9]{8}\b/';
    public const PHONE_REPLACE = '<a href="tel:$0" target="_blank">$0</a>';
}
