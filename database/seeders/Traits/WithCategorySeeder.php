<?php

namespace Database\Seeders\Traits;

use Illuminate\Support\Facades\DB;

trait WithCategorySeeder
{
    /**
     * Seed categories into DB
     *
     * @param array<\App\Objects\CategoryObject> $categories
     *
     * @return void
     */
    protected function seedCategories(array $categories)
    {
        DB::transaction(function () use ($categories) {
            $slugIdMap = [];

            foreach ($categories as $category) {
                $category->save($slugIdMap);
            }
        });
    }
}
