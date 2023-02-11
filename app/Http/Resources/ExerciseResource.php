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
        'language',
        'type',
        'learnables',
        'lessons',
        'categories',
    ];

    /**
     * On-demand loadable counts.
     */
    protected array $loadableCounts = [
        'language',
        'type',
        'learnables',
        'lessons',
        'categories',
    ];

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return [
            'id'           => $this->id,
            'definition'   => $this->definition,
            'description'  => $this->description,
            'motivation'   => $this->motivation,
            'language_id'  => $this->whenNotLoaded('language', $this->language_id),
            'type_id'      => $this->whenNotLoaded('type', $this->type_id),
            '#learnables'  => $this->whenCounted('learnables'),
            '#words'       => $this->whenCounted('words'),
            '#expressions' => $this->whenCounted('expressions'),
            '#sentences'   => $this->whenCounted('sentences'),
            '#lessons'     => $this->whenCounted('lessons'),
            '#categories'  => $this->whenCounted('categories'),
            'language'     => LanguageResource::make($this->whenLoaded('language')),
            'type'         => ExerciseTypeResource::make($this->whenLoaded('type')),
            'learnables'   => LearnableResource::collection($this->whenLoaded('learnables')),
            'words'        => LearnableResource::collection($this->whenLoaded('words')),
            'expressions'  => LearnableResource::collection($this->whenLoaded('expressions')),
            'sentences'    => LearnableResource::collection($this->whenLoaded('sentences')),
            'lessons'      => LessonResource::collection($this->whenLoaded('lessons')),
            'categories'   => CategoryResource::collection($this->whenLoaded('categories')),
            'created_at'   => $this->created_at->toDateTimeString(),
            'updated_at'   => $this->updated_at->toDateTimeString(),
        ];
    }
}
