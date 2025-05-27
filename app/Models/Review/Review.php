<?php

namespace App\Models\Review;

use App\Enums\Review\ReviewRating;
use App\Enums\Review\ReviewStatus;
use App\Models\Traits\HasShortUlid;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;

    use HasShortUlid, HasUlids;

    protected $guarded = [];

    protected function casts()
    {
        return [
            'rating' => ReviewRating::class,
            'status' => ReviewStatus::class,
        ];
    }

    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }

    public function flags(): HasMany
    {
        return $this->hasMany(ReviewFlag::class);
    }

    /**
     * Scope a query to only include reviews with a specific status.
     */
    #[Scope]
    protected function forStatus(Builder $query, ReviewStatus $status): void
    {
        $query->where('status', $status);
    }
}
