<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\UserAction;
use App\Events\UserActivity;
use App\Models\Traits\HasContacts;
use App\Models\Traits\HasLikes;
use App\Models\Traits\HasModelUpdates;
use App\Models\Traits\HasReviews;
use App\Models\Traits\HasShortUlid;
use App\Models\Traits\HasViews;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasShortUlid, HasUlids, Notifiable;
    use HasContacts, HasLikes, HasModelUpdates, HasReviews, HasViews;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'phone_verified_at' => 'datetime',
            'last_activity_at' => 'datetime',
            'dob' => 'datetime',
            'gender' => Gender::class,
            'last_activity' => UserAction::class,
            'password' => 'hashed',
        ];
    }

    protected function hasSetupPassword(): Attribute
    {
        return Attribute::make(
            get: fn () => ! is_null($this->password),
        );
    }

    protected function hasVerifiedPhone(): Attribute
    {
        return Attribute::make(
            get: fn () => ! is_null($this->phone_verified_at),
        );
    }

    protected function age(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->dob ? $this->dob->diffInYears(now()) : null,
        );
    }

    protected function isAdult(): Attribute
    {
        return Attribute::make(
            get: function () {
                $adultAge = config('settings.adult_age', 18);

                if ($adultAge <= 0) {
                    return true;
                }

                return $this->age >= $adultAge;
            }
        );
    }

    /**
     * Scopes
     */
    #[Scope]
    protected function byIdentifier(Builder $query, string $identifier): void
    {
        $query->where(function (Builder $query) use ($identifier) {
            $query->where('email', $identifier)
                ->orWhere('username', $identifier)
                ->orWhere('id', $identifier);
        });
    }

    /**
     * Relationships
     */
    public function shop(): HasOne
    {
        return $this->hasOne(Shop::class);
    }

    /**
     * Methods
     */
    public function recordAction(UserAction $action)
    {
        event(new UserActivity($this, $action));
    }
}
