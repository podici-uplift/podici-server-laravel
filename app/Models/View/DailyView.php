<?php

namespace App\Models\View;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class DailyView extends Model
{
    /** @use HasFactory<\Database\Factories\DailyViewFactory> */
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
            'date' => 'datetime:Y-m-d',
        ];
    }

    public function viewable(): MorphTo
    {
        return $this->morphTo();
    }
}
