<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->setupModels();
        $this->setupMorphMap();
        $this->setupTelescope();
        $this->setupPassword();

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }

    private function setupModels()
    {
        Schema::defaultStringLength(191);

        Model::shouldBeStrict(! $this->app->environment(['prod', 'production']));
    }

    private function setupMorphMap()
    {
        Relation::enforceMorphMap([
            // 'moonshine_user' => \MoonShine\Laravel\Models\MoonshineUser::class,
            // 'moonshine_user_role' => \MoonShine\Laravel\Models\MoonshineUserRole::class,

            'category' => \App\Models\Category::class,
            'contact' => \App\Models\Contact::class,
            'shop' => \App\Models\Shop::class,
            'user' => \App\Models\User::class,
        ]);
    }

    private function setupTelescope()
    {
        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    private function setupPassword()
    {
        Password::defaults(function () {
            $rule = Password::min(8);

            return $this->app->environment(['prod', 'production'])
                ? $rule->mixedCase()->numbers()->symbols()->uncompromised()
                : $rule;
        });
    }
}
