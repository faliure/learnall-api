<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Hash;

trait HasAttributeMutators
{
    public function mutateToUcwords(mixed $attr)
    {
        return $this->mutateIfString($attr, strtolower(...), ucwords(...));
    }

    public function mutateToLower(mixed $attr)
    {
        return $this->mutateIfString($attr, strtolower(...));
    }

    public function mutateToUpper(mixed $attr)
    {
        return $this->mutateIfString($attr, strtoupper(...));
    }

    public function mutateToHash(mixed $attr)
    {
        return $this->mutateIfString($attr, Hash::make(...));
    }

    public function mutateIfString(mixed $attr, ...$args)
    {
        return (is_scalar($attr) && $args)
            ? $this->pipeMutators($attr, ...$args)
            : $attr;
    }

    public function pipeMutators($attr, ...$mutators)
    {
        return array_reduce($mutators, fn ($c, $m) => $m($c), $attr);
    }
}
