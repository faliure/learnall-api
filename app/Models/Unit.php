<?php

namespace App\Models;

use App\Extensions\Model;
use App\Models\Traits\Mutators\UnitMutators;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Unit extends Model
{
    use UnitMutators;

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class);
    }
}
