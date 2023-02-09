<?php

namespace App\Models\Traits\Mutators;

use App\Enums\CefrLevel;
use App\Models\Traits\HasAttributeMutators;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait CourseMutators
{
    use HasAttributeMutators;

    public function name(): Attribute
    {
        return Attribute::set($this->mutateToUcwords(...));
    }

    public function cefrLevel(): Attribute
    {
        return Attribute::set(function (CefrLevel|string $attribute) {
            return is_string($attribute)
                ? strtoupper($attribute)
                : $attribute;
        });
    }
}
