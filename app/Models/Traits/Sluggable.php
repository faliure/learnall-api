<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait Sluggable
{
    /**
     * The attribute of the model that the slug is based of.
     */
    protected string $sluggableAttribute = 'name';

    public static function bootSluggable()
    {
        static::creating(function (Model $sluggable) {
            if ($sluggable->slug) {
                return;
            }

            $sluggable->slug = Str::slug($sluggable->{$sluggable->sluggableAttribute});
        });
    }
}
