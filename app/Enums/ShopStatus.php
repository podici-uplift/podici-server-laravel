<?php

namespace App\Enums;

enum ShopStatus: string
{
    /**
     * User is yet to publish shop
     */
    case DRAFT = 'draft';

    /**
     * Shop is running
     */
    case ACTIVE = 'active';

    /**
     * User marked the shop as inactive:
     * - Perharps, taking a break
     */
    case INACTIVE = 'inactive';

    /**
     * System marked the shop as suspended:
     *
     * - Users reported the shop, and it is pending investigation
     */
    case SUSPENDED = 'suspended';

    /**
     * Admins banned the shop
     */
    case BANNED = 'banned';

    /**
     * The user opted to close his shop
     */
    case CLOSED = 'closed';
}
