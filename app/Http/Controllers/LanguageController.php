<?php

namespace App\Http\Controllers;

use App\Extensions\Controller;
use App\Models\Learnable;

class LanguageController extends Controller
{
    public function learnable()
    {
        return Learnable::resourcesQuery()
            ->whereHas('translation')
            ->inRandomOrder()
            ->first();
    }
}
