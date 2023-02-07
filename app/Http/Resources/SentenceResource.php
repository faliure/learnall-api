<?php

namespace App\Http\Resources;

use App\Extensions\Resource;

class SentenceResource extends Resource
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
            'sentence'    => $this->sentence,
            'meaning'     => $this->meaning,
            'language_id' => $this->language_id,
            'language'    => $this->language->longName,
            'words'       => WordResource::collection($this->whenLoaded('words')),
        ];
    }
}
