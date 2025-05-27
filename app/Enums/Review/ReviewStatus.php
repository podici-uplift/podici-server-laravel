<?php

namespace App\Enums\Review;

enum ReviewStatus: string
{
    /**
     * Review is pending approval from owner
     */
    case PENDING = 'pending';

    /**
     * Review has been approved and is visible
     */
    case APPROVED = 'approved';

    /**
     * Review is visible but is locked from further interactions by the owner
     */
    case LOCKED = 'locked';

    /**
     * Review was rejected
     */
    case REJECTED = 'rejected';

    /**
     * Review is under investigation by admins
     */
    case UNDER_INVESTIGATION = 'under_investigation';
}
