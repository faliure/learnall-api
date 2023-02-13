<?php

namespace App\Models\Pivots;

use App\Exceptions\InvalidRelationException;
use App\Extensions\Pivot;
use App\Models\Exercise;
use App\Models\Learnable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExerciseLearnable extends Pivot
{
    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }

    public function learnable(): BelongsTo
    {
        return $this->belongsTo(Learnable::class);
    }

    protected static function booted()
    {
        parent::booted();

        static::creating(function (ExerciseLearnable $pivot) {
            if ($pivot->exercise->language_id !== $pivot->learnable->language_id) {
                throw new InvalidRelationException(
                    'Cannot link Exercises and Learnables with a different language ' .
                    "(Excercise #{$pivot->exercise_id} | Learnable #{$pivot->learnable_id})"
                );
            }
        });
    }
}
