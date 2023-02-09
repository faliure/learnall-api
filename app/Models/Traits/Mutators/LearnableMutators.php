<?php

namespace App\Models\Traits\Mutators;

use App\Models\Traits\HasAttributeMutators;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait LearnableMutators
{
    use HasAttributeMutators;

    public function type(): Attribute
    {
        return Attribute::set($this->mutateToLower(...));
    }
}
