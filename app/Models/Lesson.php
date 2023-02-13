<?php

namespace App\Models;

use App\Extensions\Model;
use App\Models\Traits\LearnedLanguageScope;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lesson extends Model
{
    use LearnedLanguageScope;

    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class);
    }

    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class);
    }
}
