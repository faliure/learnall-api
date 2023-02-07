<?php

namespace App\Http\Resources;

use App\Extensions\Resource;

class WordResource extends Resource
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
            'word'        => $this->word,
            'meaning'     => $this->meaning,
            'language_id' => $this->language_id,
            'language'    => $this->language->longName,
        ];
    }
}
