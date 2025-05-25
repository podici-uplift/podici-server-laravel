<?php

namespace App\Jobs\Views;

use App\Models\DailyView;
use App\Models\View;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AggregateDailyViewsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $viewableType,
        public string $viewableId,
        public string $date
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $viewsCount = View::where('viewable_type', $this->viewableType)
            ->where('viewable_id', $this->viewableId)
            ->whereDate('viewed_at', $this->date)
            ->count();

        DailyView::updateOrCreate([
            'viewable_type' => $this->viewableType,
            'viewable_id' => $this->viewableId,
            'date' => $this->date,
        ], [
            'views' => $viewsCount
        ]);
    }
}
