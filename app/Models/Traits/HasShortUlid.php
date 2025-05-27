<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

trait HasShortUlid
{
    use HasUlids;

    /**
     * Generates a short, unique identifier for this model instance.
     *
     * The resulting string is a short, URL-friendly representation of the model's ULID. The first two
     * characters are removed, and any remaining asterisks are replaced with dashes. The result is then
     * converted to uppercase.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute<string>
     */
    public function shortUlid(): Attribute
    {
        return Attribute::make(
            get: fn () => str($this->getKey())
                ->mask('*', 5, -4)
                ->replaceMatches('/[*]+/', '-')
                ->upper()
                ->substr(2)
        );
    }
}
