<?php

namespace App\Models\Traits;

use App\Enums\Review\ReviewRating;
use App\Enums\Review\ReviewStatus;
use App\Models\Review\Review;
use App\Models\User;

trait HasReviews
{
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function recordReview(
        User $reviewer,
        string $review,
        ReviewRating $rating,
        ReviewStatus $status,
        ?string $title = null,
        ?Review $parent = null,
    ) {
        return $this->reviews()->create([
            'user_id' => $reviewer->id,
            'parent_id' => optional($parent)->id,
            'title' => $title,
            'review' => $review,
            'rating' => $rating,
            'status' => $status,
        ]);
    }
}
