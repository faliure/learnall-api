<?php

namespace App\Http\Controllers\Crud;

use App\Extensions\CrudController;
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
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
    public function index(): ResourceCollection
    {
        return Unit::resourcesQuery()->with('language')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitRequest $request): UnitResource
    {
        $unit = Unit::create($request->validated());

        return $this->show($unit);
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit): UnitResource
    {
        return $unit->load('language')->resource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitRequest $request, Unit $unit): UnitResource
    {
        $unit->update($request->validated());

        return $this->show($unit);
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
