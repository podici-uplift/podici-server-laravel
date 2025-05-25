<?php

namespace App\Enums;

enum FlagStatus: string
{
    /**
     * - Users reported, and it is pending investigation
     */
    case SUSPENDED = 'suspended';

    /**
     * Admins banned
     */
    case BANNED = 'banned';

    /**
     * Admins resolved
     */
    case RESOLVED = 'resolved';
}
