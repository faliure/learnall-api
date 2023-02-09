<?php

namespace App\Http\Resources;

use App\Extensions\Resource;

class CategoryResource extends Resource
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
            'id'           => $this->id,
            'name'         => $this->name,
            'slug'         => $this->slug,
            'desrcription' => $this->description,
            'motivation'   => $this->motivation,
            '#learnables'  => $this->whenCounted('learnables'),
            '#words'       => $this->whenCounted('words'),
            '#expressions' => $this->whenCounted('expressions'),
            '#sentences'   => $this->whenCounted('sentences'),
            '#exercises'   => $this->whenCounted('exercises'),
            'learnables'   => LearnableResource::collection($this->whenLoaded('learnables')),
            'exercises'    => ExerciseResource::collection($this->whenLoaded('exercises')),
            'created_at'   => $this->created_at->toDateTimeString(),
            'updated_at'   => $this->updated_at->toDateTimeString(),
        ];
    }
}
