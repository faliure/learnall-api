<?php

namespace App\Http\Controllers\Crud;

use App\Extensions\CrudController;
use App\Http\Requests\StoreExerciseTypeRequest;
use App\Http\Requests\UpdateExerciseTypeRequest;
use App\Http\Resources\ExerciseTypeResource;
use App\Models\ExerciseType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class ExerciseTypeController extends CrudController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        return ExerciseType::resources();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExerciseTypeRequest $request): ExerciseTypeResource
    {
        $exerciseType = ExerciseType::create($request->validated());

        return $this->show($exerciseType);
    }

    /**
     * Display the specified resource.
     */
    public function show(ExerciseType $exerciseType): ExerciseTypeResource
    {
        return $exerciseType->resource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExerciseTypeRequest $request, ExerciseType $exerciseType): ExerciseTypeResource
    {
        $exerciseType->update($request->validated());

        return $this->show($exerciseType);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExerciseType $exerciseType): JsonResponse
    {
        $exerciseType->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
