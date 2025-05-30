<?php

namespace App\Models;

use App\Models\Traits\HasShortUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    /** @use HasFactory<\Database\Factories\LikeFactory> */
    use HasFactory;

    use HasShortUlid;

    protected $guarded = [];

    protected function casts()
    {
        return [
            //
        ];
    }

    /**
     * ? ***********************************************************************
     * ? Relationships
     * ? ***********************************************************************
     */
    public function likedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'liked_by');
    }
}
