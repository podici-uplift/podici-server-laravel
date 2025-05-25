<?php

namespace App\Models;

use App\Models\Traits\HasShortUlid;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class View extends Model
{
    /** @use HasFactory<\Database\Factories\ViewFactory> */
    use HasFactory, HasUlids, HasShortUlid;

    protected $guarded = [];

    protected function casts()
    {
        return [
            'viewed_at' => 'datetime:Y-m-d',
        ];
    }

    public function viewable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
