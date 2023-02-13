<?php

namespace App\Models\Pivots;

use App\Exceptions\InvalidRelationException;
use App\Extensions\Pivot;
use App\Models\Learnable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LearnableLearnable extends Pivot
{
    public function learnable(): BelongsTo
    {
        return $this->belongsTo(Learnable::class);
    }

    public function related(): BelongsTo
    {
        return $this->belongsTo(Learnable::class, 'related_to');
    }

    protected static function booted()
    {
        parent::booted();

        static::creating(function (LearnableLearnable $pivot) {
            if ($pivot->learnable->language_id !== $pivot->related->language_id) {
                throw new InvalidRelationException(
                    'Cannot link Learnables with a different language ' .
                    "(Learnable #{$pivot->learnable_id} | Related #{$pivot->related_to})"
                );
            }
        });

        static::created(function (LearnableLearnable $pivot) {
            Model::withoutEvents(
                fn () => $pivot->related->related()->attach($pivot->learnable_id)
            );
        });
    }
}
