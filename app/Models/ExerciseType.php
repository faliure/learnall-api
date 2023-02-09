<?php

namespace App\Models;

use App\Extensions\Model;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExerciseType extends Model
{
    protected $casts = [
        'requires_listening'       => 'boolean',
        'requires_speaking'        => 'boolean',
        'requires_target_keyboard' => 'boolean',
        'spec'                     => AsArrayObject::class,
    ];

    public function exercises(): HasMany
    {
        return $this->hasMany(Exercise::class, 'type_id');
    }
}
