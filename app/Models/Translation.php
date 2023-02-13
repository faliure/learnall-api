<?php

namespace App\Models;

use App\Extensions\Model;
use App\Models\Traits\Enableable;
use App\Models\Traits\Mutators\TranslationMutators;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Translation extends Model
{
    use Enableable;
    use TranslationMutators;

    protected $casts = [
        'authoritative' => 'boolean',
        'is_regex'      => 'boolean',
    ];

    public function learnable(): BelongsTo
    {
        return $this->belongsTo(Learnable::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
