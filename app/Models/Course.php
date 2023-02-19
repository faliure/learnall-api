<?php

namespace App\Models;

use App\Enums\CefrLevel;
use App\Extensions\Model;
use App\Models\Traits\Enableable;
use App\Models\Traits\Mutators\CourseMutators;
use App\Models\Traits\Sluggable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Course extends Model
{
    use CourseMutators;
    use Enableable;
    use Sluggable;

    protected $casts = [
        'cefr_level' => CefrLevel::class,
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function activeUsers(): HasMany
    {
        return $this->hasMany(User::class, 'active_course');
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function fromLanguage(): BelongsTo
    {
        return $this->belongsTo(Language::class, 'from_language');
    }

    public function levels(): HasMany
    {
        return $this->hasMany(Level::class);
    }

    public function units(): HasManyThrough
    {
        return $this->hasManyThrough(Unit::class, Level::class);
    }

    protected function sluggable(): string
    {
        return $this->fromLanguage->code . ' ' . $this->language->code;
    }
}
