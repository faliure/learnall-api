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
            'slug'        => $this->slug,
            'name'        => $this->name,
            'description' => $this->description,
            'language_id' => $this->language_id,
            'language'    => $this->language->longName,
            'lessons'     => LessonResource::collection($this->whenLoaded('lessons')),
        ];
    }
}
