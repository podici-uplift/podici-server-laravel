<?php

namespace App\Enums\Report;

enum ReportType: string
{
    case SPAM = 'spam';

    case ABUSE = 'abuse';

    case HARASSMENT = 'harassment';

    case NUDITY = 'nudity';

    case VIOLENCE = 'violence';

    case SCAM = 'scam';

    case COPYRIGHT = 'copyright';

    case OTHER = 'other';
}
