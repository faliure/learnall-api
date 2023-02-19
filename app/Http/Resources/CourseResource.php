<?php

namespace App\Http\Resources;

use App\Extensions\Resource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JsonSerializable;

class CourseResource extends Resource
{
    /**
     * On-demand loadable relations.
     */
    protected array $loadableRelations = [
        'language',
        'fromLanguage',
        'levels',
        'units',
    ];

    /**
     * On-demand loadable counts.
     */
    protected array $loadableCounts = [
        'levels',
        'units',
        'users',
        'activeUsers',
    ];

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return [
            'id'             => $this->id,
            'slug'           => $this->slug,
            'cefrLevel'      => $this->cefr_level,
            'languageId'     => $this->whenNotLoaded('language', $this->language_id),
            'fromLanguageId' => $this->whenNotLoaded('fromLanguage', $this->from_language),
            '#levels'        => $this->whenCounted('levels'),
            '#units'         => $this->whenCounted('units'),
            '#users'         => $this->whenCounted('users'),
            '#activeUsers'   => $this->whenCounted('activeUsers'),
            'language'       => LanguageResource::make($this->whenLoaded('language')),
            'fromLanguage'   => LanguageResource::make($this->whenLoaded('fromLanguage')),
            'levels'         => LevelResource::collection($this->whenLoaded('levels')),
            'units'          => UnitResource::collection($this->whenLoaded('units')),
            'enabled'        => $this->when($request->showEnabled, $this->enabled),
            'createdAt'      => $this->when($request->showTimestamps, $this->created_at->toDateTimeString()),
            'updatedAt'      => $this->when($request->showTimestamps, $this->updated_at->toDateTimeString()),
        ];
    }
}
