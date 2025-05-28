<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Like;
use App\Models\ModelUpdate;
use App\Models\Product;
use App\Models\Review\Review;
use App\Models\Review\ReviewFlag;
use App\Models\Shop;
use App\Models\User;
use App\Models\View\DailyView;
use App\Models\View\MonthlyView;
use App\Models\View\View;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class RelationshipServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->setupMorphMap();
    }

    private function setupMorphMap()
    {
        Relation::enforceMorphMap([
            // 'moonshine_user' => \MoonShine\Laravel\Models\MoonshineUser::class,
            // 'moonshine_user_role' => \MoonShine\Laravel\Models\MoonshineUserRole::class,

            // Reviews
            'review' => Review::class,
            'review_flag' => ReviewFlag::class,

            // Views
            'daily_view' => DailyView::class,
            'monthly_view' => MonthlyView::class,
            'view' => View::class,

            'category' => Category::class,
            'contact' => Contact::class,
            'like' => Like::class,
            'model_update' => ModelUpdate::class,
            'product' => Product::class,
            'shop' => Shop::class,
            'user' => User::class,
        ]);
    }
}
