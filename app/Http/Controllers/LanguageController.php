<?php

namespace App\Http\Controllers;

use App\Extensions\Controller;
use App\Models\Language;

class LanguageController extends Controller
{
    public function word(Language $language)
    {
        return $language->words()->inRandomOrder()->first()->resource();
    }
}
