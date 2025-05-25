<?php

namespace App\Providers;

use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Str;

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
        $this->setupScramble();

        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }

    private function setupModels()
    {
        Schema::defaultStringLength(191);

        Model::shouldBeStrict(! $this->app->environment(['prod', 'production']));

        Model::preventSilentlyDiscardingAttributes($this->app->environment('local'));
    }

    private function setupMorphMap()
    {
        Relation::enforceMorphMap([
            // 'moonshine_user' => \MoonShine\Laravel\Models\MoonshineUser::class,
            // 'moonshine_user_role' => \MoonShine\Laravel\Models\MoonshineUserRole::class,

            // Views
            'daily_view' => \App\Models\View\DailyView::class,
            'monthly_view' => \App\Models\View\MonthlyView::class,
            'view' => \App\Models\View\View::class,

            'category' => \App\Models\Category::class,
            'contact' => \App\Models\Contact::class,
            'model_update' => \App\Models\ModelUpdate::class,
            'product' => \App\Models\Product::class,
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

            return $this->app->environment(['prod', 'production', 'testing'])
                ? $rule->mixedCase()->numbers()->symbols()->uncompromised()
                : $rule;
        });
    }

    private function setupScramble()
    {
        Scramble::configure()->routes(function (Route $route) {
            return Str::startsWith($route->uri, 'api/');
        })->withDocumentTransformers(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::http('bearer')
            );
        });
    }
}
