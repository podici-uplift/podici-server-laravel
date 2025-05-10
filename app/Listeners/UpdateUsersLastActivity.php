<?php

namespace App\Listeners;

use App\Events\UserActivity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateUsersLastActivity
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserActivity $event): void
    {
        $event->user->update([
            'last_activity' => $event->action->name,
            'last_activity_at' => now()
        ]);
    }
}
