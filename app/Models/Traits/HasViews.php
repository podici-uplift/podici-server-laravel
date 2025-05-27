<?php

namespace App\Models\Traits;

use App\Models\User;
use App\Models\View\DailyView;
use App\Models\View\MonthlyView;
use App\Models\View\View;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasViews
{
    /**
     * ? ***********************************************************************
     * ? Relationships
     * ? ***********************************************************************
     */

    /**
     * Returns a collection of {@see View}s that belong to this model.
     *
     * @return MorphMany<View>
     */
    public function views(): MorphMany
    {
        return $this->morphMany(View::class, 'viewable');
    }

    /**
     * Returns a collection of {@see DailyView}s that belong to this model.
     *
     * @return MorphMany<DailyView>
     */
    public function dailyViews(): MorphMany
    {
        return $this->morphMany(DailyView::class, 'viewable');
    }

    /**
     * Returns a collection of {@see MonthlyView}s that belong to this model.
     *
     * @return MorphMany<MonthlyView>
     */
    public function monthlyViews(): MorphMany
    {
        return $this->morphMany(MonthlyView::class, 'viewable');
    }

    /**
     * ? ***********************************************************************
     * ? Counts
     * ? ***********************************************************************
     */

    /**
     * Get the real-time count of views for the given date or the current date if none is provided.
     *
     * @param  string|null  $date  The date for which to count views in 'Y-m-d' format. Defaults to the current date.
     *
     * @return int The count of views for the specified date.
     */
    public function realTimeCount(?string $date = null): int
    {
        return (int) $this->views()->forDate($date)->count();
    }

    /**
     * Get the count of views for the given date or the current date if none is provided.
     *
     * If the aggregated only flag is set to true, the method will only return the count from the
     * aggregated views. Otherwise, the method will first check for an aggregated view and if none
     * exists, will return the real-time count of views for the specified date.
     *
     * @param  string|null  $date  The date for which to count views in 'Y-m-d' format. Defaults to the current date.
     * @param  bool  $aggregatedOnly  Whether to only return the aggregated count, or to fall back to the real-time count if none exists.
     *
     * @return int The count of views for the specified date.
     */
    public function viewCountForDay(
        ?string $date = null,
        bool $aggregatedOnly = false
    ): int {
        $aggregatedCount = $this->dailyViews()->forDate($date)->first();

        if ($aggregatedCount || $aggregatedOnly) {
            return (int) optional($aggregatedCount)->views;
        }

        return $this->realTimeCount($date);
    }

    /**
     * Get the count of views for the given month or the current month if none is provided.
     *
     * If the aggregated only flag is set to true, the method will only return the count from the
     * aggregated views. Otherwise, the method will first check for an aggregated view and if none
     * exists, will return the sum of the daily real-time counts of views for the specified month.
     *
     * @param  string|null  $date  The month for which to count views in 'Y-m' format. Defaults to the current month.
     * @param  bool  $aggregatedOnly  Whether to only return the aggregated count, or to fall back to the sum of the daily counts if none exists.
     *
     * @return int The count of views for the specified month.
     */
    public function viewCountForMonth(
        ?string $date = null,
        bool $aggregatedOnly = false
    ): int {
        $aggregatedRecord = $this->monthlyViews()->forMonth($date)->first();

        if ($aggregatedRecord || $aggregatedOnly) {
            return (int) optional($aggregatedRecord)->views;
        }

        return $this->dailyViews()->forMonth($date)->sum('views');
    }

    /**
     * Get the count of views for the given year.
     *
     * Aggregates the views from the monthly records and returns the total count.
     *
     * @param  int  $year  The year for which to count views.
     *
     * @return int The count of views for the specified year.
     */
    public function viewCountForYear(int $year): int
    {
        return $this->monthlyViews()->forYear($year)->sum('views');
    }

    /**
     * Returns the total count of views for the model.
     *
     * If `$includeRealTime` is `true`, the method will return the sum of the aggregated views
     * (i.e. the sum of the monthly views and the daily views of the current month except the current day)
     * and the real-time count of views for the current day.
     *
     * If `$includeRealTime` is `false` (default), the method will only return the sum of the aggregated views.
     *
     * @param  bool  $includeRealTime  Whether to include the real-time count of views or not.
     *
     * @return int The total count of views.
     */
    public function totalViewCount(bool $includeRealTime = false): int
    {
        $currentMonth = now()->format('Y-m');
        $currentDate = now()->format('Y-m-d');

        // Sum of all monthly views except the current month
        $monthlyViewsTotal = $this->monthlyViews()
            ->notMonth($currentMonth)
            ->sum('views');

        // Sum of all daily views for current month except the current day
        $dailyViewsTotal = $this->dailyViews()
            ->forMonth($currentMonth)
            ->whereNot('date', $currentDate)
            ->sum('views');

        // Total aggregated views
        $totalAggregatedViews = $monthlyViewsTotal + $dailyViewsTotal;

        return $includeRealTime
            ? $totalAggregatedViews + $this->realTimeCount()
            : $totalAggregatedViews;
    }

    /**
     * ? ***********************************************************************
     * ? Methods
     * ? ***********************************************************************
     */

    /**
     * Records a new {@see View} for the given user.
     *
     * If `tracking_views` is set to false in the settings, this method will return null.
     *
     * @param User $viewer The user who is performing the view.
     *
     * @return void
     */
    public function recordView(User $viewer): void
    {
        if (! config('settings.tracking_views')) {
            return;
        }

        $this->views()->firstOrCreate([
            'user_id' => $viewer->id,
            'date' => now()->format('Y-m-d'),
        ]);
    }
}
