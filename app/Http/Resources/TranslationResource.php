<?php

namespace App\Http\Resources;

use App\Extensions\Resource;

class TranslationResource extends Resource
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
            'translation'   => $this->translation,
            'authoritative' => $this->authoritative,
            'is_regex'      => $this->is_regex,
            'enabled'       => $this->enabled,
            'language_id'   => $this->whenNotLoaded('language', $this->language_id),
            'learnable_id'  => $this->whenNotLoaded('learnable', $this->learnable_id),
            'language'      => LanguageResource::make($this->whenLoaded('language')),
            'learnable'     => LearnableResource::make($this->whenLoaded('learnable')),
            'created_at'    => $this->created_at->toDateTimeString(),
            'updated_at'    => $this->updated_at->toDateTimeString(),
        ];
    }
}
