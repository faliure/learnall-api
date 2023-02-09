<?php

namespace App\Models\Traits\Mutators;

use App\Models\Traits\HasAttributeMutators;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait UserMutators
{
    use HasAttributeMutators;

    public function name(): Attribute
    {
        return Attribute::set($this->mutateToUcwords(...));
    }

    public function email(): Attribute
    {
        return Attribute::set($this->mutateToLower(...));
    }

    public function password(): Attribute
    {
        return Attribute::set($this->mutateToHash(...));
    }
}
