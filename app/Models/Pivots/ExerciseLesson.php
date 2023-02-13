<?php

namespace App\Models\Pivots;

use App\Exceptions\InvalidRelationException;
use App\Extensions\Pivot;
use App\Models\Exercise;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExerciseLesson extends Pivot
{
    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    protected static function booted()
    {
        parent::booted();

        static::creating(function (ExerciseLesson $pivot) {
            if ($pivot->exercise->language_id !== $pivot->lesson->language_id) {
                throw new InvalidRelationException(
                    'Cannot link Execises and Lessons with a different language ' .
                    "(Excercise #{$pivot->exercise_id} | Lesson #{$pivot->lesson_id})"
                );
            }
        });
    }
}
