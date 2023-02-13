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
            $lesson = Lesson::withoutGlobalScopes()->find($pivot->lesson_id);
            $unit   = Unit::withoutGlobalScopes()->find($pivot->unit_id);

            if ($lesson->language_id !== $unit->language_id) {
                throw new InvalidRelationException(
                    'Cannot link Lessons and Units with a different language ' .
                    "(Lesson #{$lesson->id} | Unit #{$unit->id})"
                );
            }
        });
    }
}
