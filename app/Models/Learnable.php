<?php

namespace App\Models;

use App\Enums\LearnableType;
use App\Extensions\Model;
use App\Models\Pivots\ExerciseLearnable;
use App\Models\Pivots\LearnableLearnable;
use App\Models\Traits\Categorizable;
use App\Models\Traits\LearnedLanguageScope;
use App\Models\Traits\Mutators\LearnableMutators;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Learnable extends Model
{
    use Categorizable;
    use LearnableMutators;
    use LearnedLanguageScope;

    protected $casts = [
        'type' => LearnableType::class,
    ];

    public function related(): BelongsToMany
    {
        return $this->belongsToMany(
            Learnable::class,
            'learnable_learnable',
            'learnable_id',
            'related_to'
        )->using(LearnableLearnable::class)->withTimestamps();
    }

    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class)
            ->using(ExerciseLearnable::class)
            ->withTimestamps();
    }

    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class);
    }

    public function translation(): HasOne
    {
        return $this->hasOne(Translation::class)->where([
            'authoritative' => true,
            'enabled'       => true,
        ]);
    }
}
