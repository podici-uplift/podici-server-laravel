<?php

namespace App\Enums\Report;

enum ReportStatus: string
{
    case PENDING = 'pending';

    case REVIEWING = 'reviewing';

    case RESOLVED = 'resolved';

    case REJECTED = 'rejected';
}
