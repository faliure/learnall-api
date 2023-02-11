<?php

namespace App\Http\Controllers\Crud;

use App\Extensions\CrudController;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
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
    public function index(): ResourceCollection
    {
        return Lesson::resources();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request): LessonResource
    {
        $lesson = Lesson::create($request->validated());

        return $this->show($lesson);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson): LessonResource
    {
        return $lesson->resource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson): LessonResource
    {
        $lesson->update($request->validated());

        return $this->show($lesson);
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
