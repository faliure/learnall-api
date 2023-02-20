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
        /** Without eager loading, it loads the first course always, instead */
        me()->load('activeCourse');

        $table  = (new static())->getTable();
        $langId = me()?->activeCourse?->language_id;


        $builder->where("$table.language_id", $langId);
    }

    public function scopeForSpokenLanguage(Builder $builder): void
    {
        /** Without eager loading, it loads the first course always, instead */
        me()->load('activeCourse');

        $table  = (new static())->getTable();
        $langId = me()?->activeCourse?->from_language;

        $builder->where("$table.language_id", $langId);
    }
}
