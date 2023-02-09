<?php

namespace App\Http\Resources;

use App\Extensions\Resource;

class UnitResource extends Resource
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
            'language_id' => $this->whenNotLoaded('language', $this->language_id),
            'courses#'    => $this->whenCounted('courses'),
            'lessons#'    => $this->whenCounted('lessons'),
            'language'    => LanguageResource::make($this->whenLoaded('language')),
            'courses'     => CourseResource::collection($this->whenLoaded('courses')),
            'lessons'     => LessonResource::collection($this->whenLoaded('lessons')),
            'created_at'  => $this->created_at->toDateTimeString(),
            'updated_at'  => $this->updated_at->toDateTimeString(),
        ];
    }
}
