<?php

namespace App\Enums\Review;

enum ReviewFlagType: string
{
    /**
     * Endorsed by admin/moderator
     */
    case ENDORSED = 'endorsed';

    /**
     * Promoted by owner of reviewable (e.g. post/shop/product owner)
     */
    case PROMOTED = 'promoted';

    /**
     * Pinned to the top by owner of reviewable
     *
     * A max of config('settings.review.max_no_of_pins)
     */
    case PINNED = 'pinned';

    /**
     * ? -------------------------------
     * ? User Feedbacks
     * ? -------------------------------
     */

    /**
     * Marked helpful by users
     */
    case HELPFUL = 'helpful';

    /**
     * Offers unique perspective
     */
    case INSIGHTFUL = 'insightful';

    /**
     * Humorous review
     */
    case FUNNY = 'funny';

    /**
     * Not relevant to the original post
     */
    case OFF_TOPIC = 'off_topic';

    /**
     * Resolved a question or concern
     */
    case RESOLVED = 'resolved';
}
