<?php

namespace App\Enums;


enum StatusEnum: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case PENDING = 'pending';
    case REJECTED = 'rejected';
}
