<?php

namespace App\Enums\Review;

enum ReviewDisputeStatus: string
{
    /**
     * Default state, owner has not raised any dispute
     */
    case PUBLISHED = 'published';

    /**
     * Owner has raised a dispute
     */
    case DISPUTED = 'disputed';

    /**
     * Admin accepted the dispute, review is gone.
     */
    case TAKEN_DOWN = 'taken_down';

    /**
     * Admin rejected the challenge, review is final and public
     *
     * Can no longer be disputed
     */
    case UPHELD = 'upheld';
}
