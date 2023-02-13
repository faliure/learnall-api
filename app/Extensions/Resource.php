<?php

namespace App\Extensions;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource as BaseJsonResource;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use InvalidArgumentException;
use JsonSerializable;

class Resource extends BaseJsonResource
{
    /**
     * Defines which method to fetch the definition from, instead of toArray().
     */
    protected ?string $customType = null;

    /**
     * On-demand loadable relations.
     */
    protected array $loadableRelations = [];

    /**
     * On-demand loadable relations.
     */
    protected array $loadableCounts = [];

    /**
     * Manually define which fields defined in the toArray method
     * (custom or standard) should be included in the representation.
     */
    public function only(array|string $attributes): array
    {
        if (func_num_args() > 1) {
            $attributes = func_get_args();
        }

        return Arr::only($this->resolve(), $attributes);
    }

    /**
     * Retrieve a value if a relationship has not been loaded.
     *
     * @param  string  $relationship
     * @param  mixed  $value
     * @param  mixed  $default
     * @return \Illuminate\Http\Resources\MissingValue|mixed
     */
    public function whenNotLoaded(string $relationship, $value = null, $default = null)
    {
        if (func_num_args() < 3) {
            $default = new MissingValue();
        }

        return $this->whenLoaded($relationship, $default, $value);
    }

    /**
     * Retrieve a value if a relationship count has not been loaded.
     *
     * @param  string  $relationship
     * @param  mixed  $value
     * @param  mixed  $default
     * @return \Illuminate\Http\Resources\MissingValue|mixed
     */
    public function whenNotCounted(string $relationship, $value = null, $default = null)
    {
        if (func_num_args() < 3) {
            $default = new MissingValue();
        }

        return $this->whenCounted($relationship, $default, $value);
    }

    /**
     * Get the preset custom type, or null if not defined.
     */
    public function getCustomType(): ?string
    {
        return $this->customType;
    }

    /**
     * Define the custom type for this Resource.
     *
     * Example:
     *  - customType 'brief' requires a method toBriefArray() to be defined
     *  - customType 'full' requires a method toFullArray() to be defined
     */
    public function setCustomType(string $customType): self
    {
        $this->customType = $customType;

        if (! method_exists($this, $method = $this->getCustomTypeDefinitionMethod())) {
            throw new InvalidArgumentException(
                "Custom toArray() method '{$method}()' is not defined on this Resource"
            );
        }

        return $this;
    }

    /**
     * Create a new anonymous resource collection.
     */
    public static function collection($resource): AnonymousResourceCollection
    {
        if ($resource instanceof Collection) {
            $resolver = static::make($resource);

            app()->call($resolver->loadLoadableRelations(...));
            app()->call($resolver->loadLoadableCounts(...));
        }

        return parent::collection($resource);
    }

    /**
     * Resolve the resource to an array.
     *
     * @param  \Illuminate\Http\Request|null  $request
     */
    public function resolve($request = null): array
    {
        if ($this->resource instanceof Model) {
            $this->loadLoadableRelations($request);
            $this->loadLoadableCounts($request);
        }

        return parent::resolve($request);
    }

    /**
     * Transform the resource into a custom array, if the type is defined,
     * or the default JsonResource representation if the type is undefined.
     *
     * Notice that, if toArray is defined on the child, this won't be called.
     */
    public function toArray(Request $request): array|Arrayable|JsonSerializable
    {
        if (! $customToArray = $this->getCustomTypeDefinitionMethod()) {
            return parent::toArray($request);
        }

        return $this->$customToArray($request);
    }

    /**
     * Get the method to call, instead of toArray, if this reasource
     * has a custom type.
     */
    private function getCustomTypeDefinitionMethod(): ?string
    {
        if (is_null($this->customType)) {
            return null;
        }

        return Str::camel("to_{$this->customType}_array");
    }

    /**
     * Load auto-loadable relations for this resource.
     */
    private function loadLoadableRelations(Request $request): void
    {
        $requested = in_array('*', Arr::wrap($request->withRelations))
            ? $this->loadableRelations
            : $request->get('withRelations', []);

        $request->offsetUnset('withRelations');

        $loadRelations = array_intersect($this->loadableRelations, $requested);

        foreach ($loadRelations as $relation) {
            $this->resource->load($relation);
        }
    }

    /**
     * Load auto-loadable counts for this resource.
     */
    private function loadLoadableCounts(Request $request): void
    {
        $requested = in_array('*', Arr::wrap($request->withCounters))
            ? $this->loadableCounts
            : $request->get('withCounters', []);

        $request->offsetUnset('withCounters');

        $loadCounts = array_intersect($this->loadableCounts, $requested);

        foreach ($loadCounts as $relation) {
            $this->resource->loadCount($relation);
        }
    }
}
