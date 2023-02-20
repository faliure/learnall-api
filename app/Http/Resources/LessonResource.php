<?php

namespace App\Http\Resources;

use App\Extensions\Resource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JsonSerializable;

class LessonResource extends Resource
{
    /**
     * On-demand loadable relations.
     */
    protected array $loadableRelations = [
        'unit',
        'exercises',
        'exercises.learnables',
        'exercises.learnables.translation',
        'exercises.learnables.translations',
        'categories',
    ];

    /**
     * On-demand loadable counts.
     */
    protected array $loadableCounts = [
        'exercises',
        'categories',
        'exercises.learnables',
    ];

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'slug'        => $this->slug,
            'description' => $this->description,
            'unitId'      => $this->whenNotLoaded('unit', $this->unit_id),
            '#exercises'  => $this->whenCounted('exercises'),
            '#categories' => $this->whenCounted('categories'),
            'unit'        => UnitResource::make($this->whenLoaded('unit')),
            'exercises'   => ExerciseResource::collection($this->whenLoaded('exercises')),
            'categories'  => CategoryResource::collection($this->whenLoaded('categories')),
            'enabled'     => $this->when($request->showEnabled, $this->enabled),
            'createdAt'   => $this->when($request->showTimestamps, $this->created_at->toDateTimeString()),
            'updatedAt'   => $this->when($request->showTimestamps, $this->updated_at->toDateTimeString()),
        ];
    }
}
