<?php

namespace App\Listeners;

use App\Events\UserActivity;

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
            'last_activity' => $event->action,
            'last_activity_at' => now(),
        ]);
    }
}
