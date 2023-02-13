<?php

namespace App\Http\Resources;

use App\Extensions\Resource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JsonSerializable;

class TranslationResource extends Resource
{
    /**
     * On-demand loadable relations.
     */
    protected array $loadableRelations = [
        'learnable',
        'language',
    ];

    /**
     * On-demand loadable counts.
     */
    protected array $loadableCounts = [
        'learnable',
        'language',
    ];

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return [
            'id'            => $this->id,
            'translation'   => $this->translation,
            'authoritative' => $this->authoritative,
            'is_regex'      => $this->is_regex,
            'language_id'   => $this->whenNotLoaded('language', $this->language_id),
            'learnable_id'  => $this->whenNotLoaded('learnable', $this->learnable_id),
            'language'      => LanguageResource::make($this->whenLoaded('language')),
            'learnable'     => LearnableResource::make($this->whenLoaded('learnable')),
            'enabled'       => $this->when($request->showEnabled, $this->enabled),
            'created_at'    => $this->when($request->showTimestamps, $this->created_at->toDateTimeString()),
            'updated_at'    => $this->when($request->showTimestamps, $this->updated_at->toDateTimeString()),
        ];
    }
}
