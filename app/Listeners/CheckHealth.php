<?php

namespace App\Listeners;

use Exception;
use Illuminate\Foundation\Events\DiagnosingHealth;

class CheckHealth
{
    /**
     * Handle the event.
     */
    public function handle(DiagnosingHealth $event): void
    {
        $this->checkForEnvKey();
    }

    private function checkForEnvKey()
    {
        if (empty(env('APP_KEY'))) {
            throw new Exception('Missing Key');
        }
    }
}
