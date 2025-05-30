<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\UserAction;
use App\Events\UserActivity;
use App\Models\Review\Review;
use App\Models\Review\ReviewFlag;
use App\Models\Traits\HasContacts;
use App\Models\Traits\HasLikes;
use App\Models\Traits\HasMedia;
use App\Models\Traits\HasModelUpdates;
use App\Models\Traits\HasReports;
use App\Models\Traits\HasReviews;
use App\Models\Traits\HasShortUlid;
use App\Models\Traits\HasViews;
use App\Models\View\View;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasContacts;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;

    use HasLikes;
    use HasMedia;
    use HasModelUpdates;
    use HasReports;
    use HasReviews;
    use HasShortUlid;
    use HasViews;
    use Notifiable;
    use SoftDeletes;

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
    /**
     * ? ***********************************************************************
     * ? Attributes
     * ? ***********************************************************************
     */

    /**
     * Determines if the user has already set up their password.
     *
     * @return bool
     */
    protected function hasSetupPassword(): Attribute
    {
        return Attribute::make(
            get: fn () => ! is_null($this->password),
        );
    }

    /**
     * Determine if the user has verified their phone number.
     */
    protected function hasVerifiedPhone(): Attribute
    {
        return Attribute::make(
            get: fn () => ! is_null($this->phone_verified_at),
        );
    }

    /**
     * Get the user's age.
     *
     * The age is calculated in years relative to the current date and time.
     *
     * @return int|null The age if the user has a date of birth, otherwise null.
     */
    protected function age(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->dob ? $this->dob->diffInYears(now()) : null,
        );
    }

    /**
     * Determine if the user is an adult.
     *
     * The age is calculated relative to the current date and time. If the age is
     * greater than or equal to the configured adult age, the user is considered
     * an adult.
     *
     * If the configured adult age is less than or equal to 0, the user is always
     * considered an adult.
     *
     * @return bool
     */
    protected function isAdult(): Attribute
    {
        return Attribute::make(
            get: function () {
                $adultAge = config('settings.adult_age', 18);

                return $adultAge <= 0 ? true : $this->age >= $adultAge;
            }
        );
    }
    /**
     * ? ***********************************************************************
     * ? Scopes
     * ? ***********************************************************************
     */

    /**
     * Scope a query to only include users with a matching email, username, or id.
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
     * ? ***********************************************************************
     * ? Relationships
     * ? ***********************************************************************
     */

    /**
     * Get the reports that were filed by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Report>
     */
    public function filedReports(): HasMany
    {
        return $this->hasMany(Report::class, 'reported_by');
    }

    public function flaggedReviews(): HasMany
    {
        return $this->hasMany(ReviewFlag::class, 'flagged_by');
    }

    public function givenLikes(): HasMany
    {
        return $this->hasMany(Like::class, 'liked_by');
    }

    /**
     * Get the views registered by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\View\View>
     */
    public function registeredViews(): HasMany
    {
        return $this->hasMany(View::class, 'viewed_by');
    }

    /**
     * The shop associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne<\App\Models\Shop>
     */
    public function shop(): HasOne
    {
        return $this->hasOne(Shop::class, 'owned_by');
    }

    public function submittedReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewed_by');
    }

    public function updatedModels(): HasMany
    {
        return $this->hasMany(ModelUpdate::class, 'updated_by');
    }

    /**
     * Get the media uploaded by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Media>
     */
    public function uploadedMedias(): HasMany
    {
        return $this->hasMany(Media::class, 'uploaded_by');
    }

    /**
     * ? ***********************************************************************
     * ? Methods
     * ? ***********************************************************************
     */

    /**
     * Records the given user action and dispatches a {@see \App\Events\UserActivity} event.
     *
     * @return void
     */
    public function recordAction(UserAction $action)
    {
        event(new UserActivity($this, $action));
    }
}
