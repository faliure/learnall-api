<?php

namespace App\Http\Controllers\Crud;

use App\Extensions\CrudController;
use App\Http\Requests\StoreTranslationRequest;
use App\Http\Requests\UpdateTranslationRequest;
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
    public function index(): ResourceCollection
    {
        return Translation::resources();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTranslationRequest $request): TranslationResource
    {
        $translation = Translation::create($request->validated());

        return $this->show($translation);
    }

    /**
     * Display the specified resource.
     */
    public function show(Translation $translation): TranslationResource
    {
        return $translation->load('language', 'learnable')->resource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTranslationRequest $request, Translation $translation): TranslationResource
    {
        $translation->update($request->validated());

        return $this->show($translation);
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
