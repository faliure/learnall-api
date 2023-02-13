<?php

namespace App\Http\Resources;

use App\Extensions\Resource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JsonSerializable;

class ExerciseTypeResource extends Resource
{
    /**
     * On-demand loadable relations.
     */
    protected array $loadableRelations = [
        'exercises',
    ];

    /**
     * On-demand loadable counts.
     */
    protected array $loadableCounts = [
        'exercises',
    ];

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return [
            'id'                       => $this->id,
            'type'                     => $this->type,
            'requires_listening'       => $this->requires_listening,
            'requires_speaking'        => $this->requires_speaking,
            'requires_target_keyboard' => $this->requires_target_keyboard,
            'description'              => $this->description,
            'spec'                     => $this->spec,
            '#exercises'               => $this->whenCounted('exercises'),
            'exercises'                => ExerciseResource::collection($this->whenLoaded('exercises')),
            'enabled'                  => $this->when($request->showEnabled, $this->enabled),
            'created_at'               => $this->when($request->showTimestamps, $this->created_at->toDateTimeString()),
            'updated_at'               => $this->when($request->showTimestamps, $this->updated_at->toDateTimeString()),
        ];
    }
}
