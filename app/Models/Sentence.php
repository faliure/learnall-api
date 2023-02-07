<?php

namespace App\Models;

use App\Extensions\Model;
use App\Models\Traits\Categorizable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sentence extends Model
{
    use Categorizable;

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function words(): BelongsToMany
    {
        return $this->belongsToMany(Word::class);
    }
}
