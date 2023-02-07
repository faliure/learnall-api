<?php

namespace App\Http\Resources;

use App\Extensions\Resource;

class LanguageResource extends Resource
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
            'id'        => $this->id,
            'code'      => $this->code,
            'subcode'   => $this->subcode,
            'name'      => $this->name,
            'region'    => $this->region,
            'longName'  => $this->longName,
            'words'     => $this->whenCounted('words'),
            'sentences' => $this->whenCounted('sentences'),
        ];
    }
}
