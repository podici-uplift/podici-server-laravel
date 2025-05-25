<?php

namespace App\Models\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface RecordsView
{
    public function views(): MorphMany;

    public function dailyViews(): MorphMany;

    public function viewCount(): int;

    public function recordView(User $user): void;
}
