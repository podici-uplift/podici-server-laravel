<?php

use App\Models\User;
use Carbon\Carbon;

test('Real time count', function () {
    $user = createUser();

    $count = fake()->numberBetween(1, 100);
    $date = now()->subDay()->toDateString();

    for ($i = 0; $i < $count; $i++) {
        recordView($user, $date);

        if ($i % 2 === 0) {
            recordView($user, fake()->date(max: 'last week'));
        }
    }

    expect($user->realTimeCount($date))->toBe($count);
});

test('View count for day', function () {
    $user = createUser();

    $yesterday = now()->subDay()->toDateString();
    $now = now()->toDateString();

    $aggregatedViews = fake()->numberBetween(1, 10000);

    recordDailyAggregatedView($user, $yesterday, $aggregatedViews);
    // Add extra aggregated view to show that the correct day is counted
    recordDailyAggregatedView($user, now()->subWeek()->toDateString(), $aggregatedViews);

    $realTimeViewCount = fake()->numberBetween(1, 100);

    for ($i = 0; $i < $realTimeViewCount; $i++) {
        recordView($user, $yesterday);
        recordView($user, $now);
    }

    /**
     * ! For Yesterday
     */

    // ℹ️ If aggregated view exist, then real time count is ignored
    expect(
        $user->viewCountForDay($yesterday, aggregatedOnly: false)
    )->toBe($aggregatedViews);

    expect(
        $user->viewCountForDay($yesterday, aggregatedOnly: true)
    )->toBe($aggregatedViews);

    /**
     * ! For Today
     */
    expect(
        $user->viewCountForDay($now, aggregatedOnly: false)
    )->toBe($realTimeViewCount);

    // ℹ️ No aggregated view count recorded
    expect(
        $user->viewCountForDay($now, aggregatedOnly: true)
    )->toBe(0);
});

test('View count for month', function () {
    $user = createUser();

    $currentMonth = Carbon::parse('2024-02-1');
    $previousMonth = $currentMonth->clone()->subMonth();

    $aggPrevMonthViews = fake()->numberBetween(1000, 100000);

    recordMonthlyAggregatedView(
        $user,
        $previousMonth->year,
        $previousMonth->month,
        $aggPrevMonthViews
    );

    expect(
        $user->viewCountForMonth($previousMonth->toDateString(), aggregatedOnly: true)
    )->toBe($aggPrevMonthViews);

    expect(
        $user->viewCountForMonth($previousMonth->toDateString(), aggregatedOnly: false)
    )->toBe($aggPrevMonthViews);

    expect(
        $user->viewCountForMonth($currentMonth->toDateString(), aggregatedOnly: false)
    )->toBe(0);

    expect(
        $user->viewCountForMonth($currentMonth->toDateString(), aggregatedOnly: true)
    )->toBe(0);

    $noOfDays = fake()->numberBetween(7, 28);

    $unaggCurrentMonthViews = 0;

    // Add previous month's record to ensure that only current month is counted
    recordDailyAggregatedView(
        $user,
        $previousMonth->clone()->endOfMonth()->toDateString(),
        fake()->randomNumber()
    );

    // Add next month's record to ensure that only current month is counted
    recordDailyAggregatedView(
        $user,
        $currentMonth->clone()->addMonth()->startOfMonth()->toDateString(),
        fake()->randomNumber()
    );

    for ($i = 0; $i < $noOfDays; $i++) {
        $date = $currentMonth->clone()->addDays($i)->toDateString();

        $views = fake()->numberBetween(1, 1000);

        $unaggCurrentMonthViews += $views;

        recordDailyAggregatedView($user, $date, $views);
    }

    expect(
        $user->viewCountForMonth($currentMonth->toDateString(), aggregatedOnly: false)
    )->toBe($unaggCurrentMonthViews);

    expect(
        $user->viewCountForMonth($currentMonth->toDateString(), aggregatedOnly: true)
    )->toBe(0);
});

test('View count for year', function () {
    $user = createUser();
    $year = 2024;

    $monthsIntoTheYear = fake()->numberBetween(3, 11);

    $startOfYear = Carbon::create($year, 1, 1);
    $previousYear = $startOfYear->clone()->subYear();
    $nextYear = $startOfYear->clone()->addYear();

    $expectedAggViews = 0;

    // Add previous year's record to ensure that only current year is counted
    recordMonthlyAggregatedView(
        $user,
        $previousYear->year,
        $previousYear->endOfYear()->month,
        fake()->randomNumber()
    );

    // Add next year's record to ensure that only current year is counted
    recordMonthlyAggregatedView(
        $user,
        $nextYear->year,
        $nextYear->startOfYear()->month,
        fake()->randomNumber()
    );

    expect(
        $user->viewCountForYear($year)
    )->toBe($expectedAggViews);

    for ($i = 0; $i < $monthsIntoTheYear; $i++) {
        $month = $startOfYear->addMonth()->month;

        $views = fake()->numberBetween(1, 1000);

        $expectedAggViews += $views;

        recordMonthlyAggregatedView($user, $year, $month, $views);
    }

    expect(
        $user->viewCountForYear($year)
    )->toBe($expectedAggViews);
});

test('Total view count', function () {
    $user = createUser();

    $baseDate = now()->endOfMonth();

    $this->travelTo($baseDate);

    $aggViews = 0;

    expect($user->totalViewCount())->toBe($aggViews);

    $monthsBack = fake()->numberBetween(3, 24);

    for ($i = 1; $i < $monthsBack; $i++) {
        $pastDate = $baseDate->clone()->subMonthsNoOverflow($i);

        $views = fake()->numberBetween(1, 1000);

        $aggViews += $views;

        recordMonthlyAggregatedView($user, $pastDate->year, $pastDate->month, $views);
    }

    expect($user->totalViewCount())->toBe($aggViews);

    $daysBack = fake()->numberBetween(3, 24);

    for ($i = 1; $i < $daysBack; $i++) {
        $pastDate = $baseDate->clone()->subDays($i);

        $views = fake()->numberBetween(1, 1000);

        $aggViews += $views;

        recordDailyAggregatedView($user, $pastDate->toDateString(), $views);
    }

    expect($user->totalViewCount())->toBe($aggViews);

    $realTimeViews = fake()->numberBetween(1, 100);

    for ($i = 0; $i < $realTimeViews; $i++) {
        recordView($user, $baseDate->toDateString());
    }

    expect($user->totalViewCount(includeRealTime: false))->toBe($aggViews);
    expect($user->totalViewCount(includeRealTime: true))->toBe($aggViews + $realTimeViews);
});
/**
 * ? ***********************************************************************
 * ? Helpers
 * ? ***********************************************************************
 */
function recordView(User $user, string $date): void
{
    $user->views()->firstOrCreate([
        'user_id' => createUser()->id,
        'date' => $date,
    ]);
}

function recordDailyAggregatedView(User $user, string $date, int $views): void
{
    $user->dailyViews()->updateOrCreate(
        ['date' => $date],
        ['views' => $views]
    );
}

function recordMonthlyAggregatedView(
    User $user,
    int $year,
    int $month,
    int $views
): void {
    $user->monthlyViews()->updateOrCreate(
        ['year' => $year, 'month' => $month],
        ['views' => $views]
    );
}
