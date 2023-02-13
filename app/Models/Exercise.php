<?php

namespace App\Models;

use App\Enums\LearnableType;
use App\Extensions\Model;
use App\Models\Pivots\ExerciseLearnable;
use App\Models\Pivots\ExerciseLesson;
use App\Models\Traits\Categorizable;
use App\Models\Traits\LearnedLanguageScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exercise extends Model
{
    use Categorizable;
    use LearnedLanguageScope;

    protected $casts = [
        'definition' => AsArrayObject::class,
    ];

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

    public function learnables(): BelongsToMany
    {
        return $this->belongsToMany(Learnable::class)
            ->using(ExerciseLearnable::class)
            ->withTimestamps();
    }

    public function words(): BelongsToMany
    {
        return $this->learnables()->whereNotIn('type', [
            LearnableType::Expression,
            LearnableType::Sentence,
        ]);
    }

    public function expressions(): BelongsToMany
    {
        return $this->learnables()->where('type', LearnableType::Expression);
    }

    public function sentences(): BelongsToMany
    {
        return $this->learnables()->where('type', LearnableType::Sentence);
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
