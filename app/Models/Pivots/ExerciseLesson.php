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
            $exercise = Exercise::withoutGlobalScopes()->find($pivot->exercise_id);
            $lesson   = Lesson::withoutGlobalScopes()->find($pivot->lesson_id);

            if ($exercise->language_id !== $lesson->language_id) {
                throw new InvalidRelationException(
                    'Cannot link Execises and Lessons with a different language ' .
                    "(Excercise #{$exercise->id} | Lesson #{$lesson->id})"
                );
            }
        });
    }
}
