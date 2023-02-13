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
            $learnable = Learnable::withoutGlobalScopes()->find($pivot->learnable_id);
            $related   = Learnable::withoutGlobalScopes()->find($pivot->related_to);

            if ($learnable->language_id !== $related->language_id) {
                throw new InvalidRelationException(
                    'Cannot link Learnables with a different language ' .
                    "(Learnable #{$learnable->id} | Related #{$related->id})"
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
