<?php

namespace App\Models;

use App\Enums\ContactType;
use App\Models\Traits\HasShortUlid;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Contact extends Model
{
    /** @use HasFactory<\Database\Factories\ContactFactory> */
    use HasFactory, HasUlids, HasShortUlid;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'type' => ContactType::class,
            'is_primary' => 'boolean'
        ];
    }

    public function contactable(): MorphTo
    {
        return $this->morphTo();
    }
}
