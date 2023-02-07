<?php

namespace App\Models;

use App\Enums\WordType;
use App\Extensions\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    public function words(): HasMany
    {
        return $this->hasMany(Word::class);
    }

    public function sentences(): HasMany
    {
        return $this->hasMany(Sentence::class);
    }

    public function expressions(): HasMany
    {
        return $this->hasMany(Word::class)
            ->where('type', WordType::Expression);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(Language::class, 'name', 'name')
            ->where('id', '!=', $this->id);
    }

    public function longName(): Attribute
    {
        $region = $this->region ?? 'Standard';

        return Attribute::get(fn () => "{$this->name} ({$region})");
    }
}
