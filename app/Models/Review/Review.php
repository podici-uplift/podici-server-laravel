<?php

namespace App\Models\Review;

use App\Enums\Review\ReviewDisputeStatus;
use App\Enums\Review\ReviewRating;
use App\Models\Traits\HasLikes;
use App\Models\Traits\HasShortUlid;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;

    use HasShortUlid;

    use HasLikes;

    protected $guarded = [];

    protected function casts()
    {
        return [
            'rating' => ReviewRating::class,
            'dispute_status' => ReviewDisputeStatus::class,
            'disputed_at' => 'datetime',
            'dispute_resolved_at' => 'datetime',
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

    public function flags(): HasMany
    {
        return $this->hasMany(ReviewFlag::class);
    }

    #[Scope]
    public function isVisibleToPublic(Builder $query): void
    {
        $query->whereNot('dispute_status', ReviewDisputeStatus::TAKEN_DOWN);
    }
}
