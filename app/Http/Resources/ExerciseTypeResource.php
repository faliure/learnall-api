<?php

namespace App\Http\Resources;

use App\Extensions\Resource;

class ExerciseTypeResource extends Resource
{
    /**
     * Define which relations can be dinamically loaded if the request includes
     * them in a 'with' list.
     */
    protected $loadableRelations = [
        'exercises',
    ];

    /**
     * Define which relations can be dinamically loaded if the request includes
     * them in a 'count' list.
     */
    protected $loadableCounts = [
        'exercises',
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
            'id'                       => $this->id,
            'type'                     => $this->type,
            'requires_listening'       => $this->requires_listening,
            'requires_speaking'        => $this->requires_speaking,
            'requires_target_keyboard' => $this->requires_target_keyboard,
            'description'              => $this->description,
            'spec'                     => $this->spec,
            '#exercises'               => $this->whenCounted('exercises'),
            'exercises'                => ExerciseResource::collection($this->whenLoaded('exercises')),
            'created_at'               => $this->created_at->toDateTimeString(),
            'updated_at'               => $this->updated_at->toDateTimeString(),
        ];
    }
}
