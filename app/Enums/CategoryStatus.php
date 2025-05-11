<?php

namespace App\Enums;

enum CategoryStatus: string
{
    case PROPOSED = 'proposed';
    case ACTIVE = 'active';
    case REJECTED = 'rejected';
    case DISABLED = 'disabled';
}
