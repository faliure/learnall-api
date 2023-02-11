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
        'units',
    ];

    /**
     * On-demand loadable counts.
     */
    protected array $loadableCounts = [
        'language',
        'fromLanguage',
        'units',
    ];

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return [
            'id'               => $this->id,
            'enabled'          => $this->enabled,
            'cefrLevel'        => $this->cefr_level?->value,
            'language_id'      => $this->whenNotLoaded('language', $this->language_id),
            'from_language_id' => $this->whenNotLoaded('fromLanguage', $this->from_language),
            '#units'           => $this->whenCounted('units'),
            'language'         => LanguageResource::make($this->whenLoaded('language')),
            'from_language'    => LanguageResource::make($this->whenLoaded('fromLanguage')),
            'units'            => UnitResource::collection($this->whenLoaded('units')),
            'created_at'       => $this->created_at->toDateTimeString(),
            'updated_at'       => $this->updated_at->toDateTimeString(),
        ];
    }
}
