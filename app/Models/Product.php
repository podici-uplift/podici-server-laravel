<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\FlagStatus;
use App\Enums\ProductStatus;
use App\Models\Traits\HasCategories;
use App\Models\Traits\HasLikes;
use App\Models\Traits\HasMedia;
use App\Models\Traits\HasReviews;
use App\Models\Traits\HasShortUlid;
use App\Models\Traits\HasViews;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasCategories;
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    use HasLikes;
    use HasMedia;
    use HasReviews;

    use HasShortUlid, SoftDeletes;

    use HasViews;

    protected $guarded = [];

    protected function casts()
    {
        return [
            'price' => 'float',
            'sale_price' => 'float',
            'currency' => Currency::class,
            'quantity_left' => 'boolean',
            'is_adult' => 'boolean',
            'is_listed' => 'boolean',
            'published_at' => 'datetime',
            'flag' => FlagStatus::class,
        ];
    }

    /**
     * ? ***********************************************************************
     * ? Attributes
     * ? ***********************************************************************
     */

    /**
     * Get the status of the product.
     *
     * Determines the current status of the product based on various attributes,
     * such as deletion, flags, publication date, listing status, quantity, and sale price.
     */
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => $this->getStatus($attributes),
        );
    }

    /**
     * ? ***********************************************************************
     * ? Relationships
     * ? ***********************************************************************
     */

    /**
     * The shop that owns the Product
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }
    /**
     * ? ***********************************************************************
     * ? Methods
     * ? ***********************************************************************
     */

    /**
     * Determines the current status of the product based on various attributes,
     * such as deletion, flags, publication date, listing status, quantity, and sale price.
     *
     * @param  array  $attributes  The attributes of the product.
     */
    private function getStatus(array $attributes): ProductStatus
    {
        if ($attributes['deleted_at'] != null) {
            return ProductStatus::DELETED;
        }

        if ($attributes['flag'] != null && $attributes['flag'] != FlagStatus::RESOLVED) {
            return ProductStatus::FLAGGED;
        }

        if ($attributes['published_at'] == null) {
            return ProductStatus::DRAFT;
        }

        if ($attributes['published_at'] > now()) {
            return ProductStatus::COMING_SOON;
        }

        if ($attributes['is_listed'] == false) {
            return ProductStatus::UNLISTED;
        }

        if ($attributes['quantity_left'] === 0) {
            return ProductStatus::OUT_OF_STOCK;
        }

        if ($attributes['sale_price'] != null) {
            return ProductStatus::ON_SALE;
        }

        return ProductStatus::ACTIVE;
    }

    /**
     * ? ***********************************************************************
     * ? Scopes
     * ? ***********************************************************************
     */

    /**
     * Products that are to be shown to users
     */
    #[Scope]
    protected function listed(Builder $query): void
    {
        $query->where('is_listed', true)->whereNotNull('published_at');
    }
}
