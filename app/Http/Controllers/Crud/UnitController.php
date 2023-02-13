<?php

namespace App\Http\Controllers\Crud;

use App\Extensions\CrudController;
use App\Extensions\CrudRequest;
use App\Http\Requests\Crud\StoreUnitRequest;
use App\Http\Requests\Crud\UpdateUnitRequest;
use App\Http\Resources\UnitResource;
use App\Models\Unit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class UnitController extends CrudController
{
    /**
     * Display a listing of the resource.
     */
    public function index(CrudRequest $request): ResourceCollection
    {
        return Unit::resources();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitRequest $request): UnitResource
    {
        $unit = Unit::create($request->validated());

        return $unit->resource();
    }

    /**
     * Display the specified resource.
     */
    public function show(CrudRequest $request, Unit $unit): UnitResource
    {
        return $unit->resource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitRequest $request, Unit $unit): UnitResource
    {
        $unit->update($request->validated());

        return $unit->resource();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit): JsonResponse
    {
        $unit->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
