<?php

namespace App\Models;

use App\Extensions\Model;
use App\Models\Traits\Mutators\CategoryMutators;
use App\Models\Traits\RelatesToLearnables;
use App\Models\Traits\Sluggable;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Category extends Model
{
    use Sluggable;
    use CategoryMutators;
    use RelatesToLearnables;

    public function learnables(): MorphToMany
    {
        return $this->morphedByMany(Learnable::class, 'categorizable');
    }

    public function levels(): MorphToMany
    {
        return $this->morphedByMany(Level::class, 'categorizable');
    }

    public function units(): MorphToMany
    {
        return $this->morphedByMany(Unit::class, 'categorizable');
    }

    public function lessons(): MorphToMany
    {
        return $this->morphedByMany(Lesson::class, 'categorizable');
    }

    public function exercises(): MorphToMany
    {
        return $this->morphedByMany(Exercise::class, 'categorizable');
    }
}
