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
            'language_id' => $this->unit->language_id,
            'language'    => $this->unit->language->longName,
            'unit'        => new UnitResource($this->whenLoaded('unit')),
            'exercises'   => ExerciseResource::collection($this->whenLoaded('exercises')),
        ];
    }
}
