<?php

namespace App\Http\Resources;

use App\Extensions\Resource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use JsonSerializable;

class UserResource extends Resource
{
    /**
     * On-demand loadable relations.
     */
    protected array $loadableRelations = [
        'courses',
    ];

    /**
     * On-demand loadable counts.
     */
    protected array $loadableCounts = [
        'courses',
    ];

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'email'       => $this->email,
            '#courses'    => $this->whenCounted('courses'),
            'courses'     => CourseResource::collection($this->whenLoaded('courses')),
        ];
    }
}
