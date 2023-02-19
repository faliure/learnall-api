<?php

namespace App\Http\Resources;

use App\Extensions\Resource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JsonSerializable;

class ExerciseResource extends Resource
{
    /**
     * On-demand loadable relations.
     */
    protected array $loadableRelations = [
        'type',
        'lesson',
        'learnables',
        'words',
        'expressions',
        'sentences',
        'categories',
    ];

    /**
     * On-demand loadable counts.
     */
    protected array $loadableCounts = [
        'learnables',
        'words',
        'expressions',
        'sentences',
        'categories',
    ];

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return [
            'id'           => $this->id,
            'description'  => $this->description,
            'definition'   => $this->definition,
            'typeId'       => $this->whenNotLoaded('type', $this->type_id),
            'lessonId'     => $this->whenNotLoaded('lesson', $this->lesson_id),
            '#learnables'  => $this->whenCounted('learnables'),
            '#words'       => $this->whenCounted('words'),
            '#expressions' => $this->whenCounted('expressions'),
            '#sentences'   => $this->whenCounted('sentences'),
            '#categories'  => $this->whenCounted('categories'),
            'type'         => ExerciseTypeResource::make($this->whenLoaded('type')),
            'lesson'       => LessonResource::make($this->whenLoaded('lesson')),
            'learnables'   => LearnableResource::collection($this->whenLoaded('learnables')),
            'words'        => LearnableResource::collection($this->whenLoaded('words')),
            'expressions'  => LearnableResource::collection($this->whenLoaded('expressions')),
            'sentences'    => LearnableResource::collection($this->whenLoaded('sentences')),
            'categories'   => CategoryResource::collection($this->whenLoaded('categories')),
            'enabled'      => $this->when($request->showEnabled, $this->enabled),
            'createdAt'    => $this->when($request->showTimestamps, $this->created_at->toDateTimeString()),
            'updatedAt'    => $this->when($request->showTimestamps, $this->updated_at->toDateTimeString()),
        ];
    }
}
