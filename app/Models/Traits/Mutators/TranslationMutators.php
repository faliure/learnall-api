<?php

namespace App\Models\Traits\Mutators;

use App\Models\Traits\HasAttributeMutators;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait TranslationMutators
{
    use HasAttributeMutators;

    public function authoritative(): Attribute
    {
        return Attribute::make(
            get: fn ($attribute) => (bool) $attribute,
            set: fn ($attribute) => $attribute ?: null,
        );
    }
}
