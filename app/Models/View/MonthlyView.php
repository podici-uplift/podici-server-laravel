<?php

namespace App\Models\View;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
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
    protected function forMonth(
        Builder $query,
        string|Carbon|null $date = null
    ): void {
        $date = Carbon::parse($date ?? now())->format('Y-m');

        $query->where('date', $date);
    }

    /**
     * Scope a query to exclude views for a specific month.
     *
     * @param Builder $query
     * @param string|Carbon|null $date
     *
     * @return void
     */
    #[Scope]
    protected function notMonth(
        Builder $query,
        string|Carbon|null $date = null
    ): void {
        $date = Carbon::parse($date ?? now())->format('Y-m');

        $query->whereNot('date', $date);
    }

    /**
     * Scope a query to only include views for a specific year.
     *
     * @param Builder $query
     * @param string|Carbon $date
     *
     * @return void
     */
    #[Scope]
    protected function forYear(
        Builder $query,
        ?string $year = null
    ): void {
        $year ??= now()->format('Y');

        $query->whereYear('date', $year);
    }
}
