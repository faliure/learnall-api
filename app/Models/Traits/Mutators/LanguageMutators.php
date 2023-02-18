<?php

namespace App\Models\Traits\Mutators;

use App\Models\Traits\HasAttributeMutators;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait LanguageMutators
{
    use HasAttributeMutators;

    public function code(): Attribute
    {
        return Attribute::set($this->mutateToLower(...));
    }

    public function name(): Attribute
    {
        return Attribute::set($this->mutateToUcwords(...));
    }
}
