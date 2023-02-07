<?php

namespace App\Http\Controllers\Crud;

use App\Extensions\CrudController;
use App\Http\Requests\StoreSentenceRequest;
use App\Http\Requests\UpdateSentenceRequest;
use App\Http\Resources\SentenceResource;
use App\Models\Sentence;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class SentenceController extends CrudController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        return Sentence::resourcesQuery()->with('language')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSentenceRequest $request): SentenceResource
    {
        $sentence = Sentence::create($request->validated());

        return $this->show($sentence);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sentence $sentence): SentenceResource
    {
        return $sentence->load('language')->resource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSentenceRequest $request, Sentence $sentence): SentenceResource
    {
        $sentence->update($request->validated());

        return $this->show($sentence);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sentence $sentence): JsonResponse
    {
        $sentence->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
