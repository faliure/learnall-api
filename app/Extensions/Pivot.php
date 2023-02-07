<?php

namespace App\Extensions;

use Illuminate\Database\Eloquent\Relations\Pivot as BasePivot;

class Pivot extends BasePivot
{
    public $incrementing = true;
}
