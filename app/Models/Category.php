<?php

namespace App\Models;

use App\Extensions\Model;
use App\Models\Traits\Sluggable;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Category extends Model
{
    use Sluggable;

    public function learnables(): MorphToMany
    {
        return $this->morphedByMany(Learnable::class, 'categorizable');
    }

    public function exercises(): MorphToMany
    {
        return $this->morphedByMany(Exercise::class, 'categorizable');
    }
}
