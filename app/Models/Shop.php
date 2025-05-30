<?php

namespace App\Models;

use App\Enums\ShopStatus;
use App\Models\Traits\HasCategories;
use App\Models\Traits\HasContacts;
use App\Models\Traits\HasLikes;
use App\Models\Traits\HasMedia;
use App\Models\Traits\HasModelUpdates;
use App\Models\Traits\HasReports;
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
    use HasCategories;
    use HasContacts;

    /** @use HasFactory<\Database\Factories\ShopFactory> */
    use HasFactory;

    use HasLikes;
    use HasMedia;
    use HasModelUpdates;
    use HasReviews;
    use HasShortUlid;
    use HasViews;
    use HasReports;

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
            set: fn (string $value) => [
                'name' => $value,
                'slug' => self::sluggifyName($value),
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

    /**
     * ? ***********************************************************************
     * ? Methods
     * ? ***********************************************************************
     */
    public static function nameLengthLimit(): int
    {
        return config('settings.shop.name_length_limit');
    }

    public static function sluggifyName(string $name): string
    {
        $limit = self::nameLengthLimit();

        return str($name)->limit($limit, end: '')->slug();
    }

    public static function nameUsed(string $name): bool
    {
        $slug = self::sluggifyName($name);

        return Shop::where('slug', $slug)->exists();
    }
}
