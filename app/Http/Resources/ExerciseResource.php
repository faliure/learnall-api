<?php

namespace App\Http\Resources;

use App\Extensions\Resource;

class ExerciseResource extends Resource
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
            'definition'  => $this->definition,
            'description' => $this->description,
            'motivation'  => $this->motivation,
            'language_id' => $this->whenNotLoaded('language', $this->language_id),
            'type_id'     => $this->whenNotLoaded('type', $this->type_id),
            '#learnables' => $this->whenCounted('learnables'),
            '#lessons'    => $this->whenCounted('lessons'),
            '#categories' => $this->whenCounted('categories'),
            'language'    => LanguageResource::make($this->whenLoaded('language')),
            'type'        => ExerciseTypeResource::make($this->whenLoaded('type')),
            'learnables'  => LearnableResource::collection($this->whenLoaded('learnables')),
            'lessons'     => LessonResource::collection($this->whenLoaded('lessons')),
            'categories'  => CategoryResource::collection($this->whenLoaded('categories')),
            'created_at'  => $this->created_at->toDateTimeString(),
            'updated_at'  => $this->updated_at->toDateTimeString(),
        ];
    }
}
