<?php

namespace App\Http\Resources;

use App\Extensions\Resource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JsonSerializable;

class LearnableResource extends Resource
{
    /**
     * On-demand loadable relations.
     */
    protected array $loadableRelations = [
        'language',
        'related',
        'exercises',
        'translation',
        'translations',
        'categories',
    ];

    /**
     * On-demand loadable counts.
     */
    protected array $loadableCounts = [
        'language',
        'related',
        'exercises',
        'translations',
        'categories',
    ];

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return [
            'id'            => $this->id,
            'learnable'     => $this->learnable,
            'normalized'    => $this->normalized,
            'pos'           => $this->part_of_speech,
            'languageId'    => $this->whenNotLoaded('language', $this->language_id),
            'translation'   => $this->whenLoaded('translation', fn () => $this->translation->translation),
            '#related'      => $this->whenCounted('related'),
            '#exercises'    => $this->whenCounted('exercises'),
            '#translations' => $this->whenCounted('translations'),
            '#categories'   => $this->whenCounted('categories'),
            'language'      => LanguageResource::make($this->whenLoaded('language')),
            'related'       => LearnableResource::collection($this->whenLoaded('related')),
            'exercises'     => ExerciseResource::collection($this->whenLoaded('exercises')),
            'translations'  => TranslationResource::collection($this->whenLoaded('translations')),
            'categories'    => CategoryResource::collection($this->whenLoaded('categories')),
            'createdAt'     => $this->when($request->showTimestamps, $this->created_at->toDateTimeString()),
            'updatedAt'     => $this->when($request->showTimestamps, $this->updated_at->toDateTimeString()),
        ];
    }
}
