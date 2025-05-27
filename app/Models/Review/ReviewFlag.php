<?php

namespace App\Models\Review;

use App\Enums\Review\ReviewFlagType;
use App\Models\Traits\HasShortUlid;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReviewFlag extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFlagFactory> */
    use HasFactory;

    use HasShortUlid, HasUlids, SoftDeletes;
    use SoftDeletes;

    protected $guarded = [];

    protected function casts()
    {
        return [
            'type' => ReviewFlagType::class,
        ];
    }
}
