<?php

namespace App\Jobs\Views;

use App\Models\View\DailyView;
use App\Models\View\View;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class AggregateDailyViewsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $viewableType,
        public string $viewableId,
        public string $date,
        public bool $shouldDelete = false
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::transaction(function () {
            $viewQuery = View::where('viewable_type', $this->viewableType)
                ->where('viewable_id', $this->viewableId)
                ->whereDate('viewed_at', $this->date);

            $viewsCount = $viewQuery->count();

            DailyView::updateOrCreate([
                'viewable_type' => $this->viewableType,
                'viewable_id' => $this->viewableId,
                'date' => $this->date,
            ], [
                'views' => $viewsCount
            ]);

            if ($this->shouldDelete) $viewQuery->delete();
        });
    }
}
