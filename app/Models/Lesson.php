<?php

namespace App\Models;

use App\Extensions\Model;
use App\Models\Traits\Categorizable;
use App\Models\Traits\Enableable;
use App\Models\Traits\Mutators\LessonMutators;
use App\Models\Traits\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lesson extends Model
{
    use Categorizable;
    use Enableable;
    use LessonMutators;
    use Sluggable;

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function exercises(): HasMany
    {
        return $this->hasMany(Exercise::class);
    }
}
