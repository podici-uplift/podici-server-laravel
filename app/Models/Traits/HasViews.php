<?php

namespace App\Models\Traits;

use App\Models\View\DailyView;
use App\Models\User;
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
     * The views that belong to the Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function views(): MorphMany
    {
        return $this->morphMany(View::class, 'viewable');
    }

    /**
     * The daily views that belong to the Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function dailyViews(): MorphMany
    {
        return $this->morphMany(DailyView::class, 'viewable');
    }

    /**
     * The monthly views that belong to the Model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
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
     * @param string|null $date The date for which to count views in 'Y-m-d' format. Defaults to the current date.
     * @return int The count of views for the specified date.
     */
    public function realTimeCount(?string $date = null): int
    {
        return (int) $this->views()->forDate($date)->count();
    }

    public function viewCountForDay(
        ?string $date = null,
        bool $aggregatedOnly = false
    ): int {
        $aggregatedCount = $this->dailyViews()->forDate($date)->first();

        if ($aggregatedCount || $aggregatedOnly) return (int) optional($aggregatedCount)->views;

        return $this->realTimeCount($date);
    }

    public function viewCountForMonth(
        ?string $date = null,
        bool $aggregatedOnly = false
    ): int {
        $aggregatedRecord = $this->monthlyViews()->forMonth($date)->first();

        if ($aggregatedRecord || $aggregatedOnly) return (int) optional($aggregatedRecord)->views;

        return $this->dailyViews()->forMonth($date)->sum('views');
    }

    public function viewCountForYear(int $year): int
    {
        return $this->monthlyViews()->forYear($year)->sum('views');
    }

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
     * Record a view for this model by the given user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function recordView(User $user): void
    {
        if (! config('settings.tracking_views')) return;

        $this->views()->firstOrCreate([
            'user_id' => $user->id,
            'date' => now()->format('Y-m-d'),
        ]);
    }
}
