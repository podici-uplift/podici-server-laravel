<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasShortUlid
{
    public function shortUlid(): Attribute
    {
        return Attribute::make(
            get: fn() => str($this->id)
                ->mask('*', 5, -4)
                ->replaceMatches('/[*]+/', '-')
                ->upper()
                ->substr(2)
        );
    }
}
