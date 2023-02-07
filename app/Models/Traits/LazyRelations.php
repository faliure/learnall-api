<?php

namespace App\Models\Traits;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait LazyRelations
{
    public function lazyRelation(string $relation): Model|Collection|Builder
    {
        return $this->relationLoaded($relation)
            ? $this->$relation
            : $this->$relation();
    }
}
