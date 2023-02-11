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
        'activeCourse',
        'courses',
    ];

    /**
     * On-demand loadable counts.
     */
    protected array $loadableCounts = [
        'activeCourse',
        'courses',
    ];

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'email'           => $this->email,
            'activeCourse_id' => $this->whenNotLoaded('activeCourse', $this->active_course),
            '#courses'        => $this->whenCounted('courses'),
            'activeCourse'    => CourseResource::make($this->whenLoaded('activeCourse')),
            'courses'         => CourseResource::collection($this->whenLoaded('courses')),
        ];
    }
}
