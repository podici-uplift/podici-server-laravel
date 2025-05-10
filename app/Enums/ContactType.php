<?php

namespace App\Enums;

enum ContactType: string
{
    case PHONE = "phone";
    case EMAIL = "email";
    case WHATSAPP = "whatsapp";
    case FACEBOOK = "facebook";
    case INSTAGRAM = "instagram";
    case TWITTER = "twitter";
    case TIKTOK = "tiktok";
    case LINKEDIN = "linkedin";
    case CUSTOM = "custom";
}
