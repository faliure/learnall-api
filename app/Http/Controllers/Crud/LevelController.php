<?php

namespace App\Http\Controllers\Crud;

use App\Extensions\CrudController;
use App\Extensions\CrudRequest;
use App\Http\Requests\Crud\StoreLevelRequest;
use App\Http\Requests\Crud\UpdateLevelRequest;
use App\Http\Resources\LevelResource;
use App\Models\Level;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class LevelController extends CrudController
{
    /**
     * Display a listing of the resource.
     */
    public function index(CrudRequest $request): ResourceCollection
    {
        return Level::resources();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLevelRequest $request): LevelResource
    {
        $level = Level::create($request->validated());

        return $level->resource();
    }

    /**
     * Display the specified resource.
     */
    public function show(CrudRequest $request, Level $level): LevelResource
    {
        return $level->resource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLevelRequest $request, Level $level): LevelResource
    {
        $level->update($request->validated());

        return $level->resource();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Level $level): JsonResponse
    {
        $level->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
