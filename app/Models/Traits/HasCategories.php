<?php

namespace App\Models\Traits;

use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasCategories
{
    /**
     * ? ***********************************************************************
     * ? Relationships
     * ? ***********************************************************************
     */

    /**
     * Returns a collection of {@see Category}s that are associated with this model.
     *
     * @return MorphToMany<Category>
     */
    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorizable', 'categorizables');
    }

    /**
     * ? ***********************************************************************
     * ? Counts
     * ? ***********************************************************************
     */

    /**
     * Returns the count of {@see Category}s that are associated with this model.
     *
     * @return int
     */
    public function categoriesCount(): int
    {
        return $this->categories()->count();
    }

    /**
     * ? ***********************************************************************
     * ? Methods
     * ? ***********************************************************************
     */

    /**
     * Adds a {@see Category} to this model.
     *
     * @param Category $category The category to add.
     */
    public function addCategory(Category $category): void
    {
        $this->categories()->attach($category);
    }

    /**
     * Removes a {@see Category} from this model.
     *
     * @param Category $category The category to remove.
     */
    public function removeCategory(Category $category): void
    {
        $this->categories()->detach($category);
    }
}
