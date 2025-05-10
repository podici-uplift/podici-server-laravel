<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\UserAction;
use App\Events\UserActivity;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, HasUlids, Notifiable;

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
            'username_last_updated_at' => 'datetime',
            'password_last_updated_at' => 'datetime',
            'dob' => 'datetime',
            'gender' => Gender::class,
            'last_activity' => UserAction::class,
            'password' => 'hashed',
        ];
    }

    protected function hasSetupPassword(): Attribute
    {
        return Attribute::make(
            get: fn() => !is_null($this->password),
        );
    }

    /**
     * Get the user's first name.
     */
    protected function hasVerifiedPhone(): Attribute
    {
        return Attribute::make(
            get: fn() => !is_null($this->phone_verified_at),
        );
    }

    public function recordAction(UserAction $action)
    {
        event(new UserActivity($this, $action));
    }
}
