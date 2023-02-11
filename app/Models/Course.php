<?php

namespace App\Models;

use App\Enums\CefrLevel;
use App\Extensions\Model;
use App\Models\Traits\Mutators\CourseMutators;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use CourseMutators;

    protected $casts = [
        'cefr_level' => CefrLevel::class,
        'enabled'    => 'boolean',
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

    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class);
    }
}