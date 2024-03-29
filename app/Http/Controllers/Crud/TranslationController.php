<?php

namespace App\Http\Controllers\Crud;

use App\Extensions\CrudController;
use App\Extensions\CrudRequest;
use App\Http\Requests\Crud\StoreTranslationRequest;
use App\Http\Requests\Crud\UpdateTranslationRequest;
use App\Http\Resources\TranslationResource;
use App\Models\Translation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class TranslationController extends CrudController
{
    /**
     * Display a listing of the resource.
     */
    public function index(CrudRequest $request): ResourceCollection
    {
        return Translation::resources();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTranslationRequest $request): TranslationResource
    {
        $translation = Translation::create($request->validated());

        return $translation->resource();
    }

    /**
     * Display the specified resource.
     */
    public function show(CrudRequest $request, Translation $translation): TranslationResource
    {
        return $translation->resource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTranslationRequest $request, Translation $translation): TranslationResource
    {
        $translation->update($request->validated());

        return $translation->resource();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Translation $translation): JsonResponse
    {
        $translation->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
