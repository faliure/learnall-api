<?php

namespace App\Models;

use App\Enums\PartOfSpeech;
use App\Extensions\Model;
use App\Models\Traits\Mutators\LanguageMutators;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    use LanguageMutators;

    public function variants(): HasMany
    {
        return $this->hasMany(Language::class, 'code', 'code')
            ->where('id', '!=', $this->id);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function coursesFrom(): HasMany
    {
        return $this->hasMany(Course::class, 'from_language');
    }

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function exercises(): HasMany
    {
        return $this->hasMany(Exercise::class);
    }

    public function learnables(): HasMany
    {
        return $this->hasMany(Learnable::class);
    }

    public function words(): HasMany
    {
        return $this->learnables()->whereNotIn('part_of_speech', [
            PartOfSpeech::Expression,
            PartOfSpeech::Sentence,
        ]);
    }

    public function expressions(): HasMany
    {
        return $this->learnables()->where('part_of_speech', PartOfSpeech::Expression);
    }

    public function sentences(): HasMany
    {
        return $this->learnables()->where('part_of_speech', PartOfSpeech::Sentence);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class);
    }
}
