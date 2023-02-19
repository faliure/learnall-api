<?php

namespace App\Models\Traits\Mutators;

use App\Models\Traits\HasAttributeMutators;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait UserMutators
{
    use HasAttributeMutators;
    use UcWordsNameMutator;

    public function email(): Attribute
    {
        return Attribute::set($this->mutateToLower(...));
    }

    public function password(): Attribute
    {
        return Attribute::set($this->mutateToHash(...));
    }
}
