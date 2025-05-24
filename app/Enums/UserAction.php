<?php

namespace App\Enums;

enum UserAction: string
{
    case UPDATE_PROFILE = 'profile-update';
    case CREATE_SHOP = 'shop-create';
    case UPDATE_SHOP = 'shop-update';
}
