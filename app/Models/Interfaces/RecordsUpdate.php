<?php

namespace App\Models\Interfaces;

use App\Models\ModelUpdate;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface RecordsUpdate
{
    public function updates(): MorphMany;

    public function getFieldLatestUpdate(string $field): ?ModelUpdate;

    public function recordFieldUpdate(
        string $field,
        ?string $oldValue = null,
        ?string $newValue = null,
        ?User $updatedBy = null,
    ): ?ModelUpdate;
}
