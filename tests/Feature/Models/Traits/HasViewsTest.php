<?php

use App\Models\User;
use Carbon\Carbon;

test("Real time count", function () {
    $user = createUser();

    $count = fake()->numberBetween(1, 100);
    $date = now()->subDay()->toDateString();

    for ($i = 0; $i < $count; $i++) {
        recordView($user, $date);

        if ($i % 2 === 0) recordView($user, fake()->date(max: 'last week'));
    }

    expect($user->realTimeCount($date))->toBe($count);
});

test("View count for day", function () {
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

/**
 * ? ***********************************************************************
 * ? Helpers
 * ? ***********************************************************************
 *
 */

function recordView(User $user, string $date): void
{
    $user->views()->firstOrCreate([
        'user_id' => createUser()->id,
        'date' => $date
    ]);
}

function recordDailyAggregatedView(User $user, string $date, int $views): void
{
    $user->dailyViews()->firstOrCreate([
        'date' => $date,
        'views' => $views
    ]);
}

function recordMonthlyAggregatedView(User $user, string $date, int $views): void
{
    $user->monthlyViews()->updateOrCreate(
        ['date' => $date],
        ['views' => $views]
    );
}
