<?php

namespace App\Http\Controllers\Crud;

use App\Extensions\CrudController;
use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Http\Resources\LanguageResource;
use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class LanguageController extends CrudController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        return Language::resources();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLanguageRequest $request): LanguageResource
    {
        $language = Language::create($request->validated());

        return $this->show($language);
    }

    /**
     * Display the specified resource.
     */
    public function show(Language $language): LanguageResource
    {
        return $language->resource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLanguageRequest $request, Language $language): LanguageResource
    {
        $language->update($request->validated());

        return $this->show($language);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Language $language): JsonResponse
    {
        $language->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
