<?php

namespace App\Extensions;

use Illuminate\Http\Resources\Json\JsonResource as BaseJsonResource;
use Illuminate\Http\Resources\MissingValue;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use InvalidArgumentException;

class Resource extends BaseJsonResource
{
    /**
     * Defines which method to fetch the definition from, instead of toArray().
     */
    protected $customType = null;

    /**
     * Transform the resource into a custom array, if the type is defined,
     * or the default JsonResource representation if the type is undefined.
     *
     * Notice that, if toArray is defined on the child, this won't be called.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (! $customToArray = $this->getCustomTypeDefinitionMethod()) {
            return parent::toArray($request);
        }

        return $this->$customToArray($request);
    }

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
    public function whenNotLoaded($relationship, $value = null, $default = null)
    {
        if (func_num_args() < 3) {
            $default = new MissingValue;
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
    public function whenNotCounted($relationship, $value = null, $default = null)
    {
        if (func_num_args() < 3) {
            $default = new MissingValue;
        }

        return $this->whenCounted($relationship, $default, $value);
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

    public function getCustomType(): string
    {
        return $this->customType;
    }

    protected function getCustomTypeDefinitionMethod(): ?string
    {
        if (is_null($this->customType)) {
            return null;
        }

        return Str::camel("to_{$this->customType}_array");
    }
}
