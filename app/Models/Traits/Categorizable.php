<?php

namespace App\Models\Traits;

use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Categorizable
{
    public function categories(): MorphToMany
    {
        return $this->morphToMany(Category::class, 'categorizable');
    }

    public function hasCategory(Category|string $category): bool
    {
        return $category instanceof Category
            ? $this->categories->contains('id', $category->id)
            : $this->categories->contains('name', $category);
    }

    public function doesntHaveCategory(Category|string $category): bool
    {
        return ! $this->hasCategory($category);
    }

    public function hasAllCategories(iterable $categories): bool
    {
        return collect($categories)
            ->map(fn ($c) => $this->hasCategory($c))
            ->doesntContain(false);
    }

    public function hasAnyCategory(iterable $categories): bool
    {
        return collect($categories)
            ->map(fn ($c) => $this->hasCategory($c))
            ->contains(true);
    }

    public function doesntHaveAnyCategory(iterable $categories): bool
    {
        return ! $this->hasAnyCategory($categories);
    }

    public function categorizeAs(Category|string $category)
    {
        if ($this->doesntHaveCategory($category)) {
            $this->categories()->attach(
                $this->modelizeCategory($category)
            );
        }

        return $this;
    }

    public function uncategorizeFrom(Category|string $category)
    {
        if ($this->hasCategory($category)) {
            $this->categories()->detach(
                $this->modelizeCategory($category)
            );
        }

        return $this;
    }

    /**
     * Take a Category model or a Category name and return the Category model in either case.
     *
     * @param Category|string $category
     *
     * @return Category
     * @throws ModelNotFoundException if $category is a string and no Category by that name exists
     */
    private function modelizeCategory(Category|string $category): Category
    {
        return $category instanceof Category
            ? $category
            : Category::whereName($category)->firstOrFail();
    }
}
