<?php

namespace App\Models;

use App\Enums\LearnableType;
use App\Extensions\Model;
use App\Models\Traits\Categorizable;
use App\Models\Traits\Mutators\LearnableMutators;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Learnable extends Model
{
    use Categorizable;
    use LearnableMutators;

    protected $casts = [
        'type' => LearnableType::class,
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function related(): BelongsToMany
    {
        return $this->belongsToMany(
            Learnable::class,
            'learnable_learnable',
            'learnable_id',
            'related_to'
        )->withPivot('relation_type');
    }

    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class);
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
