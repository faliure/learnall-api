<?php

namespace App\Models\Traits\Mutators;

use App\Models\Traits\HasAttributeMutators;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait UcWordsNameMutator
{
    use HasAttributeMutators;

    public function name(): Attribute
    {
        return Attribute::set($this->mutateToUcwords(...));
    }
}
