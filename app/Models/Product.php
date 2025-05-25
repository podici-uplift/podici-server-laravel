<?php

namespace App\Models;

use App\Enums\Currency;
use App\Enums\FlagStatus;
use App\Enums\ProductStatus;
use App\Models\Interfaces\RecordsView;
use App\Models\Traits\HasShortUlid;
use App\Models\Traits\HasViews;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model implements RecordsView
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    use HasUlids,
        HasShortUlid,
        SoftDeletes,
        HasViews;

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
            'flag' => FlagStatus::class
        ];
    }

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class);
    }

    public function status(): ProductStatus
    {
        if ($this->deleted_at != null) return ProductStatus::DELETED;

        if ($this->flag != null && $this->flag != FlagStatus::RESOLVED) return ProductStatus::FLAGGED;

        if ($this->published_at == null) return ProductStatus::DRAFT;

        if ($this->published_at > now()) return ProductStatus::COMING_SOON;

        if ($this->is_listed == false) return ProductStatus::UNLISTED;

        if ($this->quantity_left === 0) return ProductStatus::OUT_OF_STOCK;

        if ($this->sale_price != null) return ProductStatus::ON_SALE;

        return ProductStatus::ACTIVE;
    }

    /**
     * Products that are to be shown to users
     */
    #[Scope]
    protected function listed(Builder $query): void
    {
        $query->where('is_listed', true)->whereNotNull('published_at');
    }
}
