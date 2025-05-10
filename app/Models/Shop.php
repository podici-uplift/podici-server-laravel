<?php

namespace App\Models;

use App\Enums\ShopStatus;
use App\Models\Traits\HasCategories;
use App\Models\Traits\HasContacts;
use App\Models\Traits\HasShortUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shop extends Model
{
    /** @use HasFactory<\Database\Factories\ShopFactory> */
    use HasFactory, HasContacts, HasShortUlid, HasCategories;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'is_adult_shop' => 'boolean',
            'status' => ShopStatus::class,
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
