<?php

namespace App\Http\Resources;

use App\Extensions\Resource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JsonSerializable;

class LevelResource extends Resource
{
    /**
     * On-demand loadable relations.
     */
    protected array $loadableRelations = [
        'course',
        'units',
        'lessons',
        'categories',
    ];

    /**
     * On-demand loadable counts.
     */
    protected array $loadableCounts = [
        'units',
        'lessons',
        'categories',
    ];

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return [
            'id'          => $this->id,
            'slug'        => $this->slug,
            'name'        => $this->name,
            'description' => $this->description,
            'courseId'    => $this->whenNotLoaded('course', $this->course_id),
            '#units'      => $this->whenCounted('units'),
            '#lessons'    => $this->whenCounted('lessons'),
            '#categories' => $this->whenCounted('categories'),
            'course'      => CourseResource::make($this->whenLoaded('course')),
            'units'       => UnitResource::collection($this->whenLoaded('units')),
            'lessons'     => LessonResource::collection($this->whenLoaded('lessons')),
            'categories'  => CategoryResource::collection($this->whenLoaded('categories')),
            'enabled'     => $this->when($request->showEnabled, $this->enabled),
            'createdAt'   => $this->when($request->showTimestamps, $this->created_at->toDateTimeString()),
            'updatedAt'   => $this->when($request->showTimestamps, $this->updated_at->toDateTimeString()),
        ];
    }
}
