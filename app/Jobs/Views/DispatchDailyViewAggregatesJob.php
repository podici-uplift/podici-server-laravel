<?php

namespace App\Jobs\Views;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;

class DispatchDailyViewAggregatesJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected string $date,
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $viewables = DB::table('views')
            ->select('viewable_type', 'viewable_id')
            ->whereDate('viewed_at', $this->date)
            ->distinct()
            ->cursor()
            ->each(fn($viewable) => $this->dispatchAggregateJob($viewable));
    }

    private function dispatchAggregateJob(object $viewable)
    {
        AggregateDailyViewsJob::dispatch(
            $viewable->viewable_type,
            $viewable->viewable_id,
            $this->date
        );
    }
}
