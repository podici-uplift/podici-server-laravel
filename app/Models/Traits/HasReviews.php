<?php

namespace App\Models\Traits;

use App\Enums\Review\ReviewRating;
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
     * @param  bool  $publicOnly  Whether to count only public reviews.
     */
    public function reviewsCount(bool $publicOnly = true): int
    {
        return $this->reviews()->when(
            $publicOnly,
            fn ($query) => $query->isVisibleToPublic()
        )->count();
    }

    /**
     * Returns the average rating of all reviews that belong to this model.
     */
    public function averageRating(): float
    {
        return $this->reviews()->isVisibleToPublic()->average('rating');
    }

    /**
     * ? ***********************************************************************
     * ? Methods
     * ? ***********************************************************************
     */

    /**
     * Creates a new {@see Review} belonging to this model.
     *
     * @param  User  $reviewer  The user who is writing the review.
     * @param  string  $review  The actual text of the review.
     * @param  ReviewRating  $rating  The numeric rating given in the review.
     * @param  string|null  $title  The title of the review. Optional.
     * @return Review The newly created review.
     */
    public function recordReview(
        User $reviewer,
        string $review,
        ReviewRating $rating,
        ?string $title = null,
    ) {
        return $this->reviews()->create([
            'user_id' => $reviewer->id,
            'title' => $title,
            'review' => $review,
            'rating' => $rating,
        ]);
    }
}
