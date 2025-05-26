<?php

namespace App\Models\View;

use App\Models\Traits\HasShortUlid;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class DailyView extends Model
{
    /** @use HasFactory<\Database\Factories\DailyViewFactory> */
    use HasFactory;

    use HasUlids, HasShortUlid;

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


    /**
     * ? ***********************************************************************
     * ? Relationships
     * ? ***********************************************************************
     */

    public function viewable(): MorphTo
    {
        return $this->morphTo();
    }


    /**
     * ? ***********************************************************************
     * ? Scopes
     * ? ***********************************************************************
     */

    /**
     * Scope a query to only include views for a specific date.
     *
     * @param Builder $query
     * @param string|Carbon $date
     *
     * @return void
     */
    #[Scope]
    protected function forDate(
        Builder $query,
        string|Carbon|null $date = null
    ): void {
        $date = Carbon::parse($date ?? now())->format('Y-m-d');

        $query->where('date', $date);
    }

    /**
     * Scope a query to only include views for a specific month.
     *
     * @param Builder $query
     * @param string|Carbon $date
     *
     * @return void
     */
    #[Scope]
    protected function forMonth(
        Builder $query,
        string|Carbon|null $date = null
    ): void {
        $date = Carbon::parse($date ?? now());

        $query->whereBetween('date', [
            $date->clone()->startOfMonth(),
            $date->clone()->endOfMonth()
        ]);
    }
}
