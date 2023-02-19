<?php

namespace App\Models;

use App\Extensions\Model;
use App\Models\Pivots\ExerciseLearnable;
use App\Models\Traits\Categorizable;
use App\Models\Traits\Enableable;
use App\Models\Traits\RelatesToLearnables;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exercise extends Model
{
    use Categorizable;
    use Enableable;
    use RelatesToLearnables;

    protected $casts = [
        'definition' => AsArrayObject::class,
    ];

    public function type(): BelongsTo
    {
        return $this->belongsTo(ExerciseType::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function learnables(): BelongsToMany
    {
        return $this->belongsToMany(Learnable::class)
            ->using(ExerciseLearnable::class)
            ->withTimestamps();
    }
}
