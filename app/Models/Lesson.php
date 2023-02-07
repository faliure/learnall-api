<?php

namespace App\Models;

use App\Extensions\Model;
use App\Models\Pivots\ExerciseLesson;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lesson extends Model
{
    public function language(): BelongsTo
    {
        return $this->unit->language();
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class)
            ->using(ExerciseLesson::class)
            ->withTimestamps();
    }
}
