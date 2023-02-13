<?php

namespace App\Models\Pivots;

use App\Exceptions\InvalidRelationException;
use App\Extensions\Pivot;
use App\Models\Lesson;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonUnit extends Pivot
{
    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    protected static function booted()
    {
        parent::booted();

        static::creating(function (LessonUnit $pivot) {
            if ($pivot->lesson->language_id !== $pivot->unit->language_id) {
                throw new InvalidRelationException(
                    'Cannot link Lessons and Units with a different language ' .
                    "(Lesson #{$pivot->lesson_id} | Unit #{$pivot->unit_id})"
                );
            }
        });
    }
}
