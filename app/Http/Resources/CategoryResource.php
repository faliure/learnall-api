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
        'learnables',
        'words',
        'expressions',
        'sentences',
        'exercises',
    ];

    /**
     * On-demand loadable counts.
     */
    protected array $loadableCounts = [
        'learnables',
        'words',
        'expressions',
        'sentences',
        'exercises',
    ];

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'slug'         => $this->slug,
            'desrcription' => $this->description,
            'motivation'   => $this->motivation,
            '#learnables'  => $this->whenCounted('learnables'),
            '#words'       => $this->whenCounted('words'),
            '#expressions' => $this->whenCounted('expressions'),
            '#sentences'   => $this->whenCounted('sentences'),
            '#exercises'   => $this->whenCounted('exercises'),
            'learnables'   => LearnableResource::collection($this->whenLoaded('learnables')),
            'words'        => LearnableResource::collection($this->whenLoaded('words')),
            'expressions'  => LearnableResource::collection($this->whenLoaded('expressions')),
            'sentences'    => LearnableResource::collection($this->whenLoaded('sentences')),
            'exercises'    => ExerciseResource::collection($this->whenLoaded('exercises')),
            'created_at'    => $this->when($request->showTimestamps, $this->created_at->toDateTimeString()),
            'updated_at'    => $this->when($request->showTimestamps, $this->updated_at->toDateTimeString()),
        ];
    }
}
