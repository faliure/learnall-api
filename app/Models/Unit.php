<?php

namespace App\Models;

use App\Extensions\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Unit extends Model
{
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
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
