<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Enableable
{
    public function initializeEnableable()
    {
        $this->mergeCasts([
            'enabled' => 'boolean',
        ]);
    }

    public static function bootEnableable()
    {
        if (! app()->environment('production')) {
            return;
        }

        $table = (new static())->getTable();

        static::addGlobalScope(
            'enableable',
            fn (Builder $builder) => $builder->where("$table.enabled", true)
        );
    }

    public function scopeEnabled(Builder $builder)
    {
        $builder
            ->withoutGlobalScope('enebleable')
            ->where("{$this->table}.enabled", true);
    }

    public function scopeDisabled(Builder $builder)
    {
        $builder
            ->withoutGlobalScope('enebleable')
            ->where("{$this->table}.enabled", false);
    }

    public function scopeWithDisabled(Builder $builder)
    {
        $builder->withoutGlobalScope('enebleable');
    }
}
