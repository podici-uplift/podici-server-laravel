<?php

namespace App\Models;

use App\Enums\CategoryStatus;
use App\Models\Traits\HasShortUlid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    use HasShortUlid;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'status' => CategoryStatus::class,
            'is_adult' => 'boolean',
        ];
    }

    /**
     * ? ***********************************************************************
     * ? Relationships
     * ? ***********************************************************************
     */
    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function shops(): MorphToMany
    {
        return $this->morphedByMany(Shop::class, 'categorizable');
    }
}
