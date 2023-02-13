<?php

namespace App\Http\Controllers\Crud;

use App\Extensions\CrudController;
use App\Extensions\CrudRequest;
use App\Http\Requests\Crud\StoreCourseRequest;
use App\Http\Requests\Crud\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Response;

class CourseController extends CrudController
{
    /**
     * Display a listing of the resource.
     */
    public function index(CrudRequest $request): ResourceCollection
    {
        return Course::resources();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request): CourseResource
    {
        $course = Course::create($request->validated());

        return $course->resource();
    }

    /**
     * Display the specified resource.
     */
    public function show(CrudRequest $request, Course $course): CourseResource
    {
        return $course->resource();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course): CourseResource
    {
        $course->update($request->validated());

        return $course->resource();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course): JsonResponse
    {
        $course->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
