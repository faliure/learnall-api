<?php

namespace App\Models;

use App\Extensions\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Category extends Model
{
    public function words(): MorphToMany
    {
        return $this->morphedByMany(Word::class, 'categorizable');
    }

    public function sentences(): MorphToMany
    {
        return $this->morphedByMany(Sentence::class, 'categorizable');
    }
}
