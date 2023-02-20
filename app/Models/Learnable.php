<?php

namespace App\Models;

use App\Enums\PartOfSpeech;
use App\Extensions\Model;
use App\Models\Pivots\LearnableLearnable;
use App\Models\Traits\BelongsToLanguage;
use App\Models\Traits\Categorizable;
use App\Models\Traits\Mutators\LearnableMutators;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Learnable extends Model
{
    use BelongsToLanguage;
    use Categorizable;
    use LearnableMutators;

    protected $casts = [
        'part_of_speech' => PartOfSpeech::class,
    ];

    public function related(): BelongsToMany
    {
        return $this->belongsToMany(
            Learnable::class,
            'learnable_learnable',
            'learnable_id',
            'related_to'
        )->using(LearnableLearnable::class)->withTimestamps();
    }

    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class)
            ->forSpokenLanguage();
    }

    public function translation(): HasOne
    {
        return $this->hasOne(Translation::class)
            ->forSpokenLanguage()
            ->where([ 'authoritative' => true ]);
    }

    public function scopeWords(Builder $builder): void
    {
        $builder->whereNotIn('part_of_speech', [
            PartOfSpeech::Expression,
            PartOfSpeech::Sentence,
        ]);
    }

    public function scopeExpressions(Builder $builder): void
    {
        $builder->where('part_of_speech', PartOfSpeech::Expression);
    }

    public function scopeSentences(Builder $builder): void
    {
        $builder->where('part_of_speech', PartOfSpeech::Sentence);
    }
}
