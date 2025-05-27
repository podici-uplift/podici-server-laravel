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
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    /**
     * ? ***********************************************************************
     * ? Counts
     * ? ***********************************************************************
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
    public function recordLike(User $liker): void
    {
        $this->likes()->firstOrCreate([
            'user_id' => $liker->id,
        ]);
    }

    public function isLikedBy(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)->exists();
    }
}
