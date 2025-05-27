<?php

namespace App\Models\Traits;

use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasLikes
{
    /**
     * ? ***********************************************************************
     * ? Relationships
     * ? ***********************************************************************
     */

    /**
     * Returns a collection of {@see Like}s that belong to this model.
     *
     * @return MorphMany<Like>
     */
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * ? ***********************************************************************
     * ? Counts
     * ? ***********************************************************************
     */

    /**
     * Returns the count of likes that belong to this model.
     */
    public function likesCount(): int
    {
        return $this->likes()->count();
    }

    /**
     * ? ***********************************************************************
     * ? Methods
     * ? ***********************************************************************
     */

    /**
     * Creates a new {@see Like} belonging to this model.
     *
     * @param  User  $liker  The user who is performing the like.
     */
    public function recordLike(User $liker): void
    {
        $this->likes()->firstOrCreate([
            'user_id' => $liker->id,
        ]);
    }

    /**
     * Determines if the model is liked by the specified user.
     *
     * @param  User  $user  The user to check for a like.
     * @return bool True if the model is liked by the user, false otherwise.
     */
    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
