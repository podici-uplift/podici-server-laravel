<?php

namespace App\Models;

use App\Models\Traits\HasShortUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ModelUpdate extends Model
{
    /** @use HasFactory<\Database\Factories\ModelUpdateFactory> */
    use HasFactory, HasShortUlid;

    protected $guarded = [];

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updateable(): MorphTo
    {
        return $this->morphTo();
    }

    public function hasCooldown(int $duration, string $unit = 'days')
    {
        if ($duration <= 0) {
            return true;
        }

        if (! config('settings.tracking_model_updates')) {
            return true;
        }

        return $this->created_at->lt(now()->sub($unit, $duration));
    }
}
