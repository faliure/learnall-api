<?php

namespace App\Models;

use App\Enums\WordType;
use App\Extensions\Model;
use App\Models\Traits\Categorizable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Word extends Model
{
    use Categorizable;

    protected $casts = [
        'type' => WordType::class,
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(WordTranslation::class);
    }

    public function sentences(): HasMany
    {
        return $this->hasMany(Sentence::class);
    }
}
