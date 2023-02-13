<?php

namespace App\Models;

use App\Extensions\Model;
use App\Models\Pivots\ExerciseLesson;
use App\Models\Pivots\LessonUnit;
use App\Models\Traits\LearnedLanguageScope;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lesson extends Model
{
    use LearnedLanguageScope;

    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class)
            ->using(LessonUnit::class)
            ->withTimestamps();
    }

    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class)
            ->using(ExerciseLesson::class)
            ->withTimestamps();
    }
}
