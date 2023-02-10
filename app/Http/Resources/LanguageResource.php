<?php

namespace App\Http\Resources;

use App\Extensions\Resource;

class LanguageResource extends Resource
{
    /**
     * Define which relations can be dinamically loaded if the request includes
     * them in a 'with' list.
     */
    protected $loadableRelations = [
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
     * Define which relations can be dinamically loaded if the request includes
     * them in a 'with' list.
     */
    protected $loadableCounts = [
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
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
