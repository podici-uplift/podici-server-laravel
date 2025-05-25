<?php

use App\Jobs\Views\AggregateDailyViewsJob;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
use App\Models\View;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Queue;

it("can aggregate daily views for :dataset", function ($modelGenerator) {
    $date = fake()->date();

    $model = $modelGenerator->create();
    $otherModel = $modelGenerator->create();

    $modelViewCount = fake()->numberBetween(1, 1000);
    $otherModelViewCount = fake()->numberBetween(1, 1000);

    View::factory()->forModel($model)->viewDate($date)->count($modelViewCount)->create();
    View::factory()->forModel($otherModel)->viewDate($date)->count($otherModelViewCount)->create();

    $this->assertDatabaseCount('views', $modelViewCount + $otherModelViewCount);

    (new AggregateDailyViewsJob($model->getMorphClass(), $model->getKey(), $date))->handle();
    (new AggregateDailyViewsJob($otherModel->getMorphClass(), $otherModel->getKey(), $date))->handle();

    $this->assertEquals($modelViewCount, $model->dailyViewCount());
    $this->assertEquals($otherModelViewCount, $otherModel->dailyViewCount());

    $this->assertDatabaseHas('daily_views', [
        'viewable_id' => $model->getKey(),
        'viewable_type' => $model->getMorphClass(),
        'date' => $date,
        'views' => $modelViewCount,
    ]);
})->with([
    'shop' => [Shop::factory()],
    'product' => [Product::factory()],
    'user' => [User::factory()],
]);
