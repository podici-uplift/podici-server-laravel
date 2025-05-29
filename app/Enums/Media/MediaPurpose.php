<?php

namespace App\Enums\Media;

use Str;

enum MediaPurpose: string
{
    case PROFILE_PICTURE = 'profile_picture';

    case PRODUCT_IMAGE = 'product_image';
    case PRODUCT_VIDEO = 'product_video';

    case REVIEW_ATTACHMENT = 'review_attachment';

    case SHOP_LOGO = 'shop_logo';
    case SHOP_BANNER = 'shop_banner';

    case VERIFICATION_DOCUMENT = 'verification_document';

    case OTHER = 'other';

    public function label(): string
    {
        return match ($this) {
            self::PROFILE_PICTURE => 'Profile Picture',
            self::PRODUCT_IMAGE => 'Product Image',
            self::PRODUCT_VIDEO => 'Product Video',
            self::REVIEW_ATTACHMENT => 'Review Attachment',
            self::SHOP_LOGO => 'Shop Logo',
            self::SHOP_BANNER => 'Shop Banner',
            self::VERIFICATION_DOCUMENT => 'Verification Document',
            self::OTHER => 'Other',
        };
    }

    public function storageDirectory(): string
    {
        $appName = Str::slug(config('app.name'));
        $env = config('app.env');

        return "$appName/$env/{$this->value}";
    }

    public function supportsVideo(): bool
    {
        return in_array($this, [
            self::PRODUCT_VIDEO,
            self::OTHER
        ]);
    }
}
