<?php

namespace App\Http\Controllers\Crud;

use App\Extensions\CrudController;
use App\Http\Requests\StoreLearnableRequest;
use App\Http\Requests\UpdateLearnableRequest;
use App\Http\Resources\LearnableResource;
use App\Models\Learnable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class LearnableController extends CrudController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): ResourceCollection
    {
        return Learnable::resources();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLearnableRequest $request): LearnableResource
    {
        $learnable = Learnable::create($request->validated());

        return $this->show($learnable);
    }

    /**
     * Display the specified resource.
     */
    public function show(Learnable $learnable): LearnableResource
    {
        return $learnable->resource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLearnableRequest $request, Learnable $learnable): LearnableResource
    {
        $learnable->update($request->validated());

        return $this->show($learnable);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Learnable $learnable): JsonResponse
    {
        $learnable->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
