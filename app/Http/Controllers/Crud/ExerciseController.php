<?php

namespace App\Http\Controllers\Crud;

use App\Extensions\CrudController;
use App\Extensions\CrudRequest;
use App\Http\Requests\Crud\StoreExerciseRequest;
use App\Http\Requests\Crud\UpdateExerciseRequest;
use App\Http\Resources\ExerciseResource;
use App\Models\Exercise;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class ExerciseController extends CrudController
{
    /**
     * Display a listing of the resource.
     */
    public function index(CrudRequest $request): ResourceCollection
    {
        return Exercise::resources();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExerciseRequest $request): ExerciseResource
    {
        $exercise = Exercise::create($request->validated());

        return $exercise->resource();
    }

    /**
     * Display the specified resource.
     */
    public function show(CrudRequest $request, Exercise $exercise): ExerciseResource
    {
        return $exercise->resource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExerciseRequest $request, Exercise $exercise): ExerciseResource
    {
        $exercise->update($request->validated());

        return $exercise->resource();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exercise $exercise): JsonResponse
    {
        $exercise->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
