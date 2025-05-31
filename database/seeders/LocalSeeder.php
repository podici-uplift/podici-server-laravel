<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Like;
use App\Models\Media;
use App\Models\Product;
use App\Models\Review\Review;
use App\Models\Shop;
use App\Models\User;
use Database\Factories\ProductFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Lottery;

class LocalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory()->count(20)->create();

        $users->each(function ($user) {
            Lottery::odds(1, 2)->winner(
                fn() => $this->createShopForUser($user)
            )->choose();
        });
    }

    private function createShopForUser(User $user)
    {
        Shop::factory()->belongsTo($user)->has(
            $this->productFactory()
        )->create();
    }

    private function productFactory(): ProductFactory
    {
        return Product::factory()
            ->has(Category::factory()->count(fake()->numberBetween(1, 4)))
            ->has(Review::factory()->count(fake()->numberBetween(3, 12)))
            ->has(Like::factory()->count(fake()->numberBetween(3, 12)))
            // ->has(Media::factory()->count(fake()->numberBetween(1, 4)), 'medias')
            ->hasMedias(fake()->numberBetween(1,5))
            ->count(fake()->numberBetween(3, 9));
    }
}
