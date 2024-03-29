<?php

namespace App\Http\Controllers\Crud;

use App\Extensions\CrudController;
use App\Extensions\CrudRequest;
use App\Http\Requests\Crud\StoreLessonRequest;
use App\Http\Requests\Crud\UpdateLessonRequest;
use App\Http\Resources\LessonResource;
use App\Models\Lesson;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class LessonController extends CrudController
{
    /**
     * Display a listing of the resource.
     */
    public function index(CrudRequest $request): ResourceCollection
    {
        return Lesson::resources();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request): LessonResource
    {
        $lesson = Lesson::create($request->validated());

        return $lesson->resource();
    }

    /**
     * Display the specified resource.
     */
    public function show(CrudRequest $request, Lesson $lesson): LessonResource
    {
        return $lesson->resource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson): LessonResource
    {
        $lesson->update($request->validated());

        return $lesson->resource();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson): JsonResponse
    {
        $lesson->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
