<?php

namespace App\Models;

use App\Enums\CategoryStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'status' => CategoryStatus::class,
            'is_adult' => 'boolean'
        ];
    }

    public function shops(): MorphToMany
    {
        return $this->morphedByMany(Shop::class, 'categorizable');
    }
}
