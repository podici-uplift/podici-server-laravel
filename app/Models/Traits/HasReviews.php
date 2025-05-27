<?php

namespace App\Models\Traits;

use App\Enums\Review\ReviewRating;
use App\Enums\Review\ReviewStatus;
use App\Models\Review\Review;
use App\Models\User;

trait HasReviews
{
    /**
     * ? ***********************************************************************
     * ? Relationships
     * ? ***********************************************************************
     */

    /**
     * Returns a collection of {@see Review}s that belong to this model.
     *
     * @return MorphMany<Review>
     */
    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    /**
     * ? ***********************************************************************
     * ? Counts
     * ? ***********************************************************************
     */

    /**
     * Returns the count of reviews that belong to this model.
     *
     * @return int
     */
    public function reviewsCount(): int
    {
        return $this->reviews()->count();
    }

    /**
     * ? ***********************************************************************
     * ? Methods
     * ? ***********************************************************************
     */

    /**
     * Creates a new {@see Review} belonging to this model.
     *
     * @param User $reviewer The user who is writing the review.
     * @param string $review The actual text of the review.
     * @param ReviewRating $rating The numeric rating given in the review.
     * @param ReviewStatus $status The current status of the review.
     * @param string|null $title The title of the review. Optional.
     * @param Review|null $parent The parent review, if this is a reply. Optional.
     *
     * @return Review The newly created review.
     */
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
