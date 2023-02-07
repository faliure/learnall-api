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
            $exercise = Exercise::find($pivot->{$pivot->getForeignKey()});
            $lesson   = Lesson::find($pivot->{$pivot->getOtherKey()});

            if ($exercise->language_id !== $lesson->language->id) {
                throw new InvalidRelationException(
                    'Cannot add Execise to Lesson of a different language ' .
                    "(Excercise #{$exercise->id} | Lesson #{$lesson->id})"
                );
            }
        });
    }
}
