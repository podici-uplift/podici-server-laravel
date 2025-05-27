<?php

namespace App\Models\View;

use App\Models\Traits\HasShortUlid;
use Carbon\Carbon;
use Carbon\Month;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MonthlyView extends Model
{
    /** @use HasFactory<\Database\Factories\MonthlyViewFactory> */
    use HasFactory;

    use HasShortUlid, HasUlids;

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
            'year' => 'integer',
            'month' => Month::class,
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
     * @param  string|Carbon  $date
     */
    #[Scope]
    protected function forMonth(
        Builder $query,
        string|Carbon|null $date = null
    ): void {
        $date = Carbon::parse($date ?? now());

        $query->where(function ($query) use ($date) {
            $query->where('year', $date->year)
                ->where('month', $date->month);
        });
    }

    /**
     * Scope a query to exclude views for a specific month.
     */
    #[Scope]
    protected function notMonth(
        Builder $query,
        string|Carbon|null $date = null
    ): void {
        $date = Carbon::parse($date ?? now());

        $query->whereNot(function ($query) use ($date) {
            $query->where('year', $date->year)
                ->where('month', $date->month);
        });
    }

    /**
     * Scope a query to only include views for a specific year.
     *
     * @param  string|Carbon  $date
     */
    #[Scope]
    protected function forYear(
        Builder $query,
        ?string $year = null
    ): void {
        $year ??= now()->format('Y');

        $query->where('year', $year);
    }
}
