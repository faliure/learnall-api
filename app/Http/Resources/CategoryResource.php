<?php

namespace App\Http\Resources;

use App\Extensions\Resource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JsonSerializable;

class CategoryResource extends Resource
{
    /**
     * On-demand loadable relations.
     */
    protected array $loadableRelations = [
        'levels',
        'units',
        'lessons',
        'exercises',
        'learnables',
        'words',
        'expressions',
        'sentences',
    ];

    /**
     * On-demand loadable counts.
     */
    protected array $loadableCounts = [
        'levels',
        'units',
        'lessons',
        'exercises',
        'learnables',
        'words',
        'expressions',
        'sentences',
    ];

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return [
            'id'           => $this->id,
            'slug'         => $this->slug,
            'name'         => $this->name,
            'desrcription' => $this->description,
            '#levels'      => $this->whenCounted('levels'),
            '#units'       => $this->whenCounted('units'),
            '#lessons'     => $this->whenCounted('lessons'),
            '#exercises'   => $this->whenCounted('exercises'),
            '#learnables'  => $this->whenCounted('learnables'),
            '#words'       => $this->whenCounted('words'),
            '#expressions' => $this->whenCounted('expressions'),
            '#sentences'   => $this->whenCounted('sentences'),
            'levels'       => LevelResource::collection($this->whenLoaded('levels')),
            'units'        => UnitResource::collection($this->whenLoaded('units')),
            'lessons'      => LessonResource::collection($this->whenLoaded('lessons')),
            'exercises'    => ExerciseResource::collection($this->whenLoaded('exercises')),
            'learnables'   => LearnableResource::collection($this->whenLoaded('learnables')),
            'words'        => LearnableResource::collection($this->whenLoaded('words')),
            'expressions'  => LearnableResource::collection($this->whenLoaded('expressions')),
            'sentences'    => LearnableResource::collection($this->whenLoaded('sentences')),
            'createdAt'    => $this->when($request->showTimestamps, $this->created_at->toDateTimeString()),
            'updatedAt'    => $this->when($request->showTimestamps, $this->updated_at->toDateTimeString()),
        ];
    }
}
