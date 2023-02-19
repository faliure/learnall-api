<?php

namespace App\Models\Traits;

use BadMethodCallException;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait Sluggable
{
    public static function bootSluggable()
    {
        static::creating(function (Model $sluggable) {
            if ($sluggable->slug) {
                return;
            }

            $sluggable->slug = Str::slug($sluggable->sluggable());
        });
    }

    protected function sluggable(): string
    {
        if (! is_string($this->name)) {
            throw new BadMethodCallException(
                'Cannot find a valid sluggable property for ' . class_basename($this)
            );
        }

        return $this->name;
    }
}
