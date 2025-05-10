<?php

namespace App\Enums;

enum ShopStatus: string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case ARCHIVED = 'archived';
    case SUSPENDED = 'suspended';
    case BANNED = 'banned';
    // case TERMINATED = 'terminated';
}
