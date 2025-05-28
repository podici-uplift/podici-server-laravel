<?php

namespace App\Enums\Media;

enum MediaPurpose: string
{
    case PROFILE_PICTURE = 'profile_picture';

    case PRODUCT_IMAGE = 'product_image';
    case PRODUCT_VIDEO = 'product_video';

    case REVIEW_ATTACHMENT = 'review_attachment';

    case SHOP_LOGO = 'shop_logo';
    case SHOP_BANNER = 'shop_banner';

    case VERIFICATION_DOCUMENT = 'verification_document';

    case OTEHR = 'other';
}
