<?php

namespace App\Models;

use App\Extensions\Model;
use App\Models\Traits\Categorizable;
use App\Models\Traits\Enableable;
use App\Models\Traits\Mutators\LevelMutators;
use App\Models\Traits\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Level extends Model
{
    use Categorizable;
    use Enableable;
    use LevelMutators;
    use Sluggable;

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function lessons(): HasManyThrough
    {
        return $this->hasManyThrough(Lesson::class, Unit::class);
    }
}
