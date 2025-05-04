<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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

            'user' => \App\Models\User::class,
        ]);
    }
}
