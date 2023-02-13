<?php

namespace Database\Factories\Traits;

use Illuminate\Database\Eloquent\Factories\Factory;

trait CanBeDisabled
{
    /**
     * Indicate that the entity is disabled.
     */
    public function disabled(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'enabled' => false,
        ]);
    }
}
