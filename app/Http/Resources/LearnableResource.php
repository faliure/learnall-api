<?php

namespace App\Http\Resources;

use App\Extensions\Resource;

class LearnableResource extends Resource
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
            'id'            => $this->id,
            'learnable'     => $this->learnable,
            'type'          => $this->type,
            'language_id'   => $this->whenNotLoaded('language', $this->language_id),
            '#related'      => $this->whenCounted('related'),
            '#exercises'    => $this->whenCounted('exercises'),
            '#translations' => $this->whenCounted('translations'),
            '#categories'   => $this->whenCounted('categories'),
            'language'      => LanguageResource::make($this->whenLoaded('language')),
            'related'       => LearnableResource::collection($this->whenLoaded('related')),
            'exercises'     => ExerciseResource::collection($this->whenLoaded('exercises')),
            'translation'   => TranslationResource::make($this->whenLoaded('translation')),
            'translations'  => TranslationResource::collection($this->whenLoaded('translations')),
            'categories'    => CategoryResource::collection($this->whenLoaded('categories')),
            'created_at'    => $this->created_at->toDateTimeString(),
            'updated_at'    => $this->updated_at->toDateTimeString(),
        ];
    }
}
