<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;

trait RelatesToLearnables
{
    public function words(): Relation
    {
        return $this->learnables()->words();
    }

    public function expressions(): Relation
    {
        return $this->learnables()->expressions();
    }

    public function sentences(): Relation
    {
        return $this->learnables()->sentences();
    }
}
