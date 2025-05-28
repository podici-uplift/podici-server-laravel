<?php

namespace App\Models;

use App\Enums\Media\MediaPurpose;
use App\Models\Traits\HasLikes;
use App\Models\Traits\HasShortUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    /** @use HasFactory<\Database\Factories\MediaFactory> */
    use HasFactory;

    use HasShortUlid;

    use HasLikes;

    protected $guarded = [];

    protected function casts()
    {
        return [
            'size' => 'integer',
            'purpose' => MediaPurpose::class,
        ];
    }

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
