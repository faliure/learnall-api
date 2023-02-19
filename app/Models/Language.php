<?php

namespace App\Models;

use App\Extensions\Model;
use App\Models\Traits\Mutators\LanguageMutators;
use App\Models\Traits\RelatesToLearnables;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Language extends Model
{
    use LanguageMutators;
    use RelatesToLearnables;

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function coursesFrom(): HasMany
    {
        return $this->hasMany(Course::class, 'from_language');
    }

    public function levels(): HasManyThrough
    {
        return $this->hasManyThrough(Level::class, Course::class);
    }

    public function learnables(): HasMany
    {
        return $this->hasMany(Learnable::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class);
    }
}
