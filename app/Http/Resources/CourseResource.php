<?php

namespace App\Http\Resources;

use App\Extensions\Resource;

class CourseResource extends Resource
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
            'id'               => $this->id,
            'enabled'          => $this->enabled,
            'cefrLevel'        => $this->cefr_level?->value,
            'language_id'      => $this->whenNotLoaded('language', $this->language_id),
            'from_language_id' => $this->whenNotLoaded('fromLanguage', $this->from_language),
            '#units'           => $this->whenCounted('units'),
            'language'         => LanguageResource::make($this->whenLoaded('language')),
            'from_language'    => LanguageResource::make($this->whenLoaded('fromLanguage')),
            'units'            => UnitResource::collection($this->whenLoaded('units')),
            'created_at'       => $this->created_at->toDateTimeString(),
            'updated_at'       => $this->updated_at->toDateTimeString(),
        ];
    }
}
