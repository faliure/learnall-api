<?php

namespace App\Models\Pivots;

use App\Exceptions\InvalidRelationException;
use App\Extensions\Pivot;
use App\Models\Course;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseUnit extends Pivot
{
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    protected static function booted()
    {
        parent::booted();

        static::creating(function (CourseUnit $pivot) {
            $course = Course::withoutGlobalScopes()->find($pivot->course_id);
            $unit   = Unit::withoutGlobalScopes()->find($pivot->unit_id);

            if ($course->language_id !== $unit->language_id) {
                throw new InvalidRelationException(
                    'Cannot link Courses and Units with a different language ' .
                    "(Course #{$course->id} | Unit #{$unit->id})"
                );
            }
        });
    }
}
