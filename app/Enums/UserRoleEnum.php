<?php

namespace App\Enums;


enum UserRoleEnum: string
{
    case ADMIN = 'admin';
    case USER = 'user';
    case EDITOR = 'editor';
}
