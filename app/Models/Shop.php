<?php

namespace App\Models;

use App\Enums\ShopStatus;
use App\Logics\ShopName;
use App\Models\Interfaces\RecordsUpdate;
use App\Models\Interfaces\RecordsView;
use App\Models\Traits\HasCategories;
use App\Models\Traits\HasContacts;
use App\Models\Traits\HasShortUlid;
use App\Models\Traits\HasUpdates;
use App\Models\Traits\HasViews;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shop extends Model implements RecordsUpdate, RecordsView
{
    use HasCategories,
        HasContacts,
        HasShortUlid,
        HasUlids,
        HasUpdates,
        HasViews;

    /** @use HasFactory<\Database\Factories\ShopFactory> */
    use HasFactory;

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
     * Interact with the user's first name.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => [
                'name' => $value,
                'slug' => ShopName::toSlug($value),
            ],
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
