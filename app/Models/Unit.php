<?php

namespace App\Models;

use App\Extensions\Model;
use App\Models\Traits\Categorizable;
use App\Models\Traits\Enableable;
use App\Models\Traits\Mutators\UnitMutators;
use App\Models\Traits\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Unit extends Model
{
    use Categorizable;
    use Enableable;
    use Sluggable;
    use UnitMutators;

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function exercises(): HasManyThrough
    {
        return $this->hasManyThrough(Exercise::class, Lesson::class);
    }
}
