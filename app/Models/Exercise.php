<?php

namespace App\Models;

use App\Extensions\Model;
use App\Models\Pivots\ExerciseLesson;
use App\Models\Traits\Categorizable;
use App\Models\Traits\HasLearnables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exercise extends Model
{
    use Categorizable;
    use HasLearnables;

    protected $casts = [
        'definition' => AsArrayObject::class,
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ExerciseType::class);
    }

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class)
            ->using(ExerciseLesson::class)
            ->withTimestamps();
    }

    public function units(): Builder
    {
        $lessonIdsBuilder = $this->lessons()->select('lessons.id');

        return Unit::whereHas(
            'lessons',
            fn ($q) => $q->whereIn('id', $lessonIdsBuilder)
        );
    }

    public function getUnitsAttribute(): Collection
    {
        return Unit::find($this->lessons()->pluck('unit_id'));
    }
}
