<?php

namespace App\Models\Traits;

use App\Models\ModelUpdate;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasModelUpdates
{
    /**
     * ? ***********************************************************************
     * ? Relationships
     * ? ***********************************************************************
     */

    /**
     * Returns a collection of {@see ModelUpdate}s that belong to this model.
     *
     * @return MorphMany<ModelUpdate>
     */
    public function updates(): MorphMany
    {
        return $this->morphMany(ModelUpdate::class, 'updateable');
    }

    /**
     * ? ***********************************************************************
     * ? Methods
     * ? ***********************************************************************
     */

    /**
     * Retrieves the latest {@see ModelUpdate} for the specified field.
     *
     * @param string $field The field to retrieve the latest update for.
     *
     * @return ModelUpdate|null The latest update for the specified field, or null if there are no updates.
     */
    public function getFieldLatestUpdate(string $field): ?ModelUpdate
    {
        return $this->updates()->where('field', $field)->latest()->first();
    }

    /**
     * Records a new {@see ModelUpdate} for the specified field.
     *
     * This method will return null if `tracking_model_updates` is set to false in the settings.
     *
     * @param string $field The field to record an update for.
     * @param string|null $oldValue The old value of the field before the update.
     * @param string|null $newValue The new value of the field after the update.
     * @param User|null $updatedBy The user who performed the update.
     *
     * @return ModelUpdate|null The newly created update, or null if tracking is disabled.
     */
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
