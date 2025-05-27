<?php

namespace App\Models\Traits;

use App\Models\ModelUpdate;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasModelUpdates
{
    public function updates(): MorphMany
    {
        return $this->morphMany(ModelUpdate::class, 'updateable');
    }

    public function getFieldLatestUpdate(string $field): ?ModelUpdate
    {
        return $this->updates()->where('field', $field)->latest()->first();
    }

    public function recordFieldUpdate(
        string $field,
        ?string $oldValue = null,
        ?string $newValue = null,
        ?User $updatedBy = null,
    ): ?ModelUpdate {
        if (! config('settings.tracking_model_updates')) {
            return null;
        }

        return $this->updates()->create([
            'updated_by' => optional($updatedBy)->id,
            'field' => $field,
            'old_value' => $oldValue,
            'new_value' => $newValue,
        ]);
    }
}
