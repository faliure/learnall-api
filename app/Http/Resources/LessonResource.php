<?php

namespace App\Http\Resources;

use App\Extensions\Resource;

class LessonResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'motivation'  => $this->motivation,
            '#units'      => $this->whenCounted('units'),
            '#exercises'  => $this->whenCounted('exercises'),
            'units'       => UnitResource::collection($this->whenLoaded('units')),
            'exercises'   => ExerciseResource::collection($this->whenLoaded('exercises')),
            'created_at'  => $this->created_at->toDateTimeString(),
            'updated_at'  => $this->updated_at->toDateTimeString(),
        ];
    }
}
