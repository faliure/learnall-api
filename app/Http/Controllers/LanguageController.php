<?php

namespace App\Http\Controllers;

use App\Extensions\Controller;
use App\Models\Language;

class LanguageController extends Controller
{
    public function learnable(Language $language)
    {
        return $language->learnables()->whereHas('translation')
            ->inRandomOrder()->first()
            ->load('translation')->resource();
    }
}
