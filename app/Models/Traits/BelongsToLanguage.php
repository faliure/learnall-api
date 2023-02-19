<?php

namespace App\Models\Traits;

use App\Models\Language;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToLanguage
{
    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function scopeForLearnedLanguage(Builder $builder): void
    {
        $scopingId = property_exists(static::class, 'useFromLanguageForScope')
            ? me()?->activeCourse?->from_language
            : me()?->activeCourse?->language_id;

        $table = (new static())->getTable();

        $builder->where("$table.language_id", $scopingId);
    }
}
