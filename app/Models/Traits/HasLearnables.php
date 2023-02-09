<?php

namespace App\Models\Traits;

use App\Enums\LearnableType;
use App\Models\Learnable;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasLearnables
{
    public function learnables(): HasMany
    {
        return $this->hasMany(Learnable::class);
    }

    public function words(): HasMany
    {
        return $this->learnables()->whereNotIn('type', [
            LearnableType::Expression,
            LearnableType::Sentence,
        ]);
    }

    public function expressions(): HasMany
    {
        return $this->learnables()->where('type', LearnableType::Expression);
    }

    public function sentences(): HasMany
    {
        return $this->learnables()->where('type', LearnableType::Sentence);
    }
}
