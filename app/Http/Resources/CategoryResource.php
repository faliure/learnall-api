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
            'name'      => $this->name,
            'slug'      => $this->slug,
            'words'     => $this->whenCounted('words'),
            'sentences' => $this->whenCounted('sentences'),
        ];
    }
}
