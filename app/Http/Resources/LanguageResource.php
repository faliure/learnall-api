<?php

namespace App\Http\Resources;

use App\Extensions\Resource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JsonSerializable;

class LanguageResource extends Resource
{
    /**
     * On-demand loadable relations.
     */
    protected array $loadableRelations = [
        'courses',
        'coursesFrom',
        'levels',
        'learnables',
        'words',
        'expressions',
        'sentences',
        'translations',
    ];

    /**
     * On-demand loadable counts.
     */
    protected array $loadableCounts = [
        'courses',
        'coursesFrom',
        'levels',
        'learnables',
        'words',
        'expressions',
        'sentences',
        'translations',
    ];

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return [
            'id'            => $this->id,
            'code'          => $this->code,
            'name'          => $this->name,
            'flag'          => $this->flag,
            '#courses'      => $this->whenCounted('courses'),
            '#coursesFrom'  => $this->whenCounted('coursesFrom'),
            '#levels'       => $this->whenCounted('levels'),
            '#learnables'   => $this->whenCounted('learnables'),
            '#words'        => $this->whenCounted('words'),
            '#expressions'  => $this->whenCounted('expressions'),
            '#sentences'    => $this->whenCounted('sentences'),
            '#translations' => $this->whenCounted('translations'),
            'courses'       => CourseResource::collection($this->whenLoaded('courses')),
            'coursesFrom'   => CourseResource::collection($this->whenLoaded('coursesFrom')),
            'levels'        => LevelResource::collection($this->whenLoaded('levels')),
            'learnables'    => LearnableResource::collection($this->whenLoaded('learnables')),
            'words'         => LearnableResource::collection($this->whenLoaded('words')),
            'expressions'   => LearnableResource::collection($this->whenLoaded('expressions')),
            'sentences'     => LearnableResource::collection($this->whenLoaded('sentences')),
            'translations'  => TranslationResource::collection($this->whenLoaded('translations')),
            'createdAt'     => $this->when($request->showTimestamps, $this->created_at->toDateTimeString()),
            'updatedAt'     => $this->when($request->showTimestamps, $this->updated_at->toDateTimeString()),
        ];
    }
}
