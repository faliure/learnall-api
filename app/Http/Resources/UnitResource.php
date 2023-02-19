<?php

namespace App\Http\Resources;

use App\Extensions\Resource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JsonSerializable;

class UnitResource extends Resource
{
    /**
     * On-demand loadable relations.
     */
    protected array $loadableRelations = [
        'level',
        'lessons',
        'exercises',
        'categories',
    ];

    /**
     * On-demand loadable counts.
     */
    protected array $loadableCounts = [
        'lessons',
        'exercises',
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
            'levelId'     => $this->whenNotLoaded('level', $this->level_id),
            '#lessons'    => $this->whenCounted('lessons'),
            '#exercises'  => $this->whenCounted('exercises'),
            '#categories' => $this->whenCounted('categories'),
            'level'       => LevelResource::make($this->whenLoaded('level')),
            'lessons'     => LessonResource::collection($this->whenLoaded('lessons')),
            'exercises'   => ExerciseResource::collection($this->whenLoaded('exercises')),
            'categories'  => CategoryResource::collection($this->whenLoaded('categories')),
            'enabled'     => $this->when($request->showEnabled, $this->enabled),
            'createdAt'   => $this->when($request->showTimestamps, $this->created_at->toDateTimeString()),
            'updatedAt'   => $this->when($request->showTimestamps, $this->updated_at->toDateTimeString()),
        ];
    }
}
