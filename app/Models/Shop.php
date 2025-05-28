<?php

namespace App\Models;

use App\Enums\ShopStatus;
use App\Logics\ShopName;
use App\Models\Traits\HasCategories;
use App\Models\Traits\HasContacts;
use App\Models\Traits\HasLikes;
use App\Models\Traits\HasMedia;
use App\Models\Traits\HasModelUpdates;
use App\Models\Traits\HasReviews;
use App\Models\Traits\HasShortUlid;
use App\Models\Traits\HasViews;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shop extends Model
{
    use HasCategories, HasContacts, HasLikes, HasModelUpdates, HasReviews, HasViews, HasMedia;

    /** @use HasFactory<\Database\Factories\ShopFactory> */
    use HasFactory;

    use HasShortUlid;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'is_adult_shop' => 'boolean',
            'status' => ShopStatus::class,
        ];
    }
    /**
     * ? ***********************************************************************
     * ? Attribute
     * ? ***********************************************************************
     */

    /**
     * Interact with the user's first name.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => [
                'name' => $value,
                'slug' => ShopName::toSlug($value),
            ],
        );
    }

    /**
     * ? ***********************************************************************
     * ? Relationships
     * ? ***********************************************************************
     */

    /**
     * Get the user that owns the Shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the products for the Shop
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Product>
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
