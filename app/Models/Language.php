<?php

namespace App\Models;

use App\Extensions\Model;
use App\Models\Traits\HasLearnables;
use App\Models\Traits\Mutators\LanguageMutators;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    use HasLearnables;
    use LanguageMutators;

    public function variants(): HasMany
    {
        return $this->hasMany(Language::class, 'code', 'code')
            ->where('id', '!=', $this->id);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function coursesFrom(): HasMany
    {
        return $this->hasMany(Course::class, 'from_language');
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function exercises(): HasMany
    {
        return $this->hasMany(Exercise::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class);
    }
}
