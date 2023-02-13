<?php

namespace App\Models;

use App\Extensions\Model;
use App\Models\Traits\LearnedLanguageScope;
use App\Models\Traits\Mutators\UnitMutators;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Unit extends Model
{
    use LearnedLanguageScope;
    use UnitMutators;

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class);
    }
}
