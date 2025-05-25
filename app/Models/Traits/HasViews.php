<?php

namespace App\Models\Traits;

use App\Models\User;
use App\Models\View;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasViews
{
    public function views(): MorphMany
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function viewCount(): int
    {
        return $this->views()->count();
    }

    public function recordView(User $user): void
    {
        if (! config('settings.tracking_views')) return;

        $this->views()->firstOrCreate([
            'user_id' => $user->id,
            'viewed_at' => now()->format('Y-m-d'),
        ]);
    }
}
