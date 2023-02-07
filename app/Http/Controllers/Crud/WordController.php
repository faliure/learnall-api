<?php

namespace App\Http\Controllers\Crud;

use App\Extensions\CrudController;
use App\Http\Requests\StoreWordRequest;
use App\Http\Requests\UpdateWordRequest;
use App\Http\Resources\WordResource;
use App\Models\Word;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class WordController extends CrudController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        return Word::resourcesQuery()->with('language')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWordRequest $request): WordResource
    {
        $word = Word::create($request->validated());

        return $this->show($word);
    }

    /**
     * Display the specified resource.
     */
    public function show(Word $word): WordResource
    {
        return $word->load('language')->resource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWordRequest $request, Word $word): WordResource
    {
        $word->update($request->validated());

        return $this->show($word);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Word $word): JsonResponse
    {
        $word->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
