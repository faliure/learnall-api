<?php

namespace App\Http\Controllers;

use App\Extensions\Controller;
use App\Http\Requests\LearnableRandomRequest;
use App\Models\Learnable;

class LearnableController extends Controller
{
    public function random(LearnableRandomRequest $request)
    {
        $base = Learnable::resourcesQuery()
            ->whereHas('translation')
            ->inRandomOrder();

        return $request->has('count')
            ? $base->limit($request->count)->get()
            : $base->first();
    }
}
