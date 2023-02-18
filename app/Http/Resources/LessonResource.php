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
        'units',
        'exercises',
    ];

    /**
     * On-demand loadable counts.
     */
    protected array $loadableCounts = [
        'units',
        'exercises',
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
            'motivation'  => $this->motivation,
            '#units'      => $this->whenCounted('units'),
            '#exercises'  => $this->whenCounted('exercises'),
            'units'       => UnitResource::collection($this->whenLoaded('units')),
            'exercises'   => ExerciseResource::collection($this->whenLoaded('exercises')),
            'enabled'     => $this->when($request->showEnabled, $this->enabled),
            'created_at'  => $this->when($request->showTimestamps, $this->created_at->toDateTimeString()),
            'updated_at'  => $this->when($request->showTimestamps, $this->updated_at->toDateTimeString()),
        ];
    }
}
