<?php

namespace App\Enums;

use App\Events\UserActivity;
use App\Models\User;

enum UserAction: string
{
    case PROFILE_UPDATE = "profile-update";
}
