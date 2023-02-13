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
        'language',
        'courses',
        'lessons',
    ];

    /**
     * On-demand loadable counts.
     */
    protected array $loadableCounts = [
        'language',
        'courses',
        'lessons',
    ];

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'motivation'  => $this->motivation,
            'language_id' => $this->whenNotLoaded('language', $this->language_id),
            '#courses'    => $this->whenCounted('courses'),
            '#lessons'    => $this->whenCounted('lessons'),
            'language'    => LanguageResource::make($this->whenLoaded('language')),
            'courses'     => CourseResource::collection($this->whenLoaded('courses')),
            'lessons'     => LessonResource::collection($this->whenLoaded('lessons')),
            'enabled'     => $this->when($request->showEnabled, $this->enabled),
            'created_at'  => $this->when($request->showTimestamps, $this->created_at->toDateTimeString()),
            'updated_at'  => $this->when($request->showTimestamps, $this->updated_at->toDateTimeString()),
        ];
    }
}
