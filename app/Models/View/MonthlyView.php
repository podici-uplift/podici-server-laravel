<?php

namespace App\Models\View;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MonthlyView extends Model
{
    /** @use HasFactory<\Database\Factories\MonthlyViewFactory> */
    use HasFactory;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $guarded = [];

    protected function casts()
    {
        return [
            'date' => 'datetime:Y-m',
        ];
    }

    public function viewable(): MorphTo
    {
        return $this->morphTo();
    }
}
