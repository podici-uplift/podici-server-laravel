<?php

use App\Jobs\Views\AggregateDailyViewsJob;
use App\Jobs\Views\DispatchDailyViewAggregatesJob;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use App\Models\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Queue;

test("It correctly dispatches the job", function () {
    Bus::fake();

    $date = fake()->date();

    $shopOne = Shop::factory()->create();
    $shopTwo = Shop::factory()->create();

    $userOne = User::factory()->create();
    $userTwo = User::factory()->create();

    $productOne = Product::factory()->create();
    $productTwo = Product::factory()->create();

    View::factory()->forModel($shopOne)->viewDate($date)->count(10)->create();
    View::factory()->forModel($shopTwo)->viewDate($date)->count(10)->create();
    View::factory()->forModel($productOne)->viewDate($date)->count(10)->create();
    View::factory()->forModel($productTwo)->viewDate($date)->count(10)->create();
    View::factory()->forModel($userOne)->viewDate($date)->count(10)->create();
    View::factory()->forModel($userTwo)->viewDate($date)->count(10)->create();

    $this->assertDatabaseCount('views', 60);

    (new DispatchDailyViewAggregatesJob($date))->handle();

    Bus::assertDispatched(AggregateDailyViewsJob::class, 6);

    assertAggregateDispatchedForModel($date, $shopOne);
    assertAggregateDispatchedForModel($date, $shopTwo);
    assertAggregateDispatchedForModel($date, $productOne);
    assertAggregateDispatchedForModel($date, $productTwo);
    assertAggregateDispatchedForModel($date, $userOne);
    assertAggregateDispatchedForModel($date, $userTwo);
});

function assertAggregateDispatchedForModel(string $date, Model $model)
{
    Bus::assertDispatched(AggregateDailyViewsJob::class, function ($job) use ($date, $model) {
        return $job->viewableType === $model->getMorphClass()
            && $job->viewableId === $model->getKey()
            && $job->date === $date;
    });
}
