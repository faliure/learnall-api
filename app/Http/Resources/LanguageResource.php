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
        'variants',
        'courses',
        'coursesFrom',
        'units',
        'exercises',
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
        'variants',
        'courses',
        'coursesFrom',
        'units',
        'exercises',
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
            'subcode'       => $this->subcode,
            'name'          => $this->name,
            'region'        => $this->region,
            'fullName'      => $this->fullName,
            '#variants'     => $this->whenCounted('variants'),
            '#courses'      => $this->whenCounted('courses'),
            '#coursesFrom'  => $this->whenCounted('coursesFrom'),
            '#units'        => $this->whenCounted('units'),
            '#exercises'    => $this->whenCounted('exercises'),
            '#learnables'   => $this->whenCounted('learnables'),
            '#words'        => $this->whenCounted('words'),
            '#expressions'  => $this->whenCounted('expressions'),
            '#sentences'    => $this->whenCounted('sentences'),
            '#translations' => $this->whenCounted('translations'),
            'variants'      => LanguageResource::collection($this->whenLoaded('variants')),
            'courses'       => CourseResource::collection($this->whenLoaded('courses')),
            'coursesFrom'   => CourseResource::collection($this->whenLoaded('coursesFrom')),
            'units'         => UnitResource::collection($this->whenLoaded('units')),
            'exercises'     => ExerciseResource::collection($this->whenLoaded('exercises')),
            'learnables'    => LearnableResource::collection($this->whenLoaded('learnables')),
            'words'         => LearnableResource::collection($this->whenLoaded('words')),
            'expressions'   => LearnableResource::collection($this->whenLoaded('expressions')),
            'sentences'     => LearnableResource::collection($this->whenLoaded('sentences')),
            'translations'  => TranslationResource::collection($this->whenLoaded('translations')),
            '#created_at'   => $this->created_at->toDateTimeString(),
            '#updated_at'   => $this->updated_at->toDateTimeString(),
        ];
    }
}
