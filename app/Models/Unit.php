<?php

namespace App\Models;

use App\Extensions\Model;
use App\Models\Pivots\CourseUnit;
use App\Models\Pivots\LessonUnit;
use App\Models\Traits\LearnedLanguageScope;
use App\Models\Traits\Mutators\UnitMutators;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Unit extends Model
{
    use LearnedLanguageScope;
    use UnitMutators;

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class)
            ->using(CourseUnit::class)
            ->withTimestamps();
    }

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class)
            ->using(LessonUnit::class)
            ->withTimestamps();
    }
}
