<?php

namespace App\Models;

use App\Extensions\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Category extends Model
{
    public function learnables(): MorphToMany
    {
        return $this->morphedByMany(Learnable::class, 'categorizable');
    }

    public function exercises(): MorphToMany
    {
        return $this->morphedByMany(Exercise::class, 'categorizable');
    }
}
