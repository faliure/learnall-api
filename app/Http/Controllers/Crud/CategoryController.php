<?php

namespace App\Http\Controllers\Crud;

use App\Extensions\CrudController;
use App\Extensions\CrudRequest;
use App\Http\Requests\Crud\StoreCategoryRequest;
use App\Http\Requests\Crud\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class CategoryController extends CrudController
{
    /**
     * Display a listing of the resource.
     */
    public function index(CrudRequest $request): ResourceCollection
    {
        return Category::resources();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): CategoryResource
    {
        $category = Category::create($request->validated());

        return $category->resource();
    }

    /**
     * Display the specified resource.
     */
    public function show(CrudRequest $request, Category $category): CategoryResource
    {
        return $category->resource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category): CategoryResource
    {
        $category->update($request->validated());

        return $category->resource();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
