<?php

use App\Models\User;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

/******************************************************************************
 *** Miscellaneous Tools ******************************************************
 *****************************************************************************/

/**
 * Get the currently authenticated user, with proper type hint.
 */
function currentUser(): ?User
{
    return auth()->user();
}

/**
 * Syntactic sugar for currentUser().
 */
function me(): ?User
{
    return currentUser();
}

/**
 * Get a property of the currently authenticated user.
 */
function my(string $property)
{
    return currentUser()->$property ?? null;
}

/**
 * Get an instance of the identity function.
 */
function identity(): Closure
{
    return fn ($x) => $x;
}

/******************************************************************************
 *** File System Tools ********************************************************
 *****************************************************************************/

/**
 * Read a json file's contents and decode it into an array or object.
 */
function readJsonFile(string $path, bool $associative = true): array|object
{
    return json_decode(File::get($path), $associative);
}

/******************************************************************************
 *** String Tools *************************************************************
 *****************************************************************************/

/**
 * Convert a list into a human-readable concatenated list.
 *
 * @param mixed $items         The items to concatenate
 * @param string $conjunction  The conjunction word to use (defaults to "and")
 *
 * @return string  The concatenated list, eg. [1, 2, 3] => "1, 2 and 3"
 */
function concatenate($items, string $conjunction = ' and ')
{
    $items = ($items instanceof Arrayable) ? $items->toArray() : Arr::wrap($items);

    return Arr::join($items, ', ', $conjunction);
}

/**
 * Concatenate items into a string list, as a conjunction (AND).
 */
function conjunction(mixed $items)
{
    return concatenate($items, ' and ');
}

/**
 * Concatenate items into a string list, as a disjunction (OR).
 */
function disjunction(mixed $items)
{
    return concatenate($items, ' or ');
}

/******************************************************************************
 *** Object/Class Tools *******************************************************
 *****************************************************************************/

/**
 * Whether a class or an object implements a given interface.
 *
 * @param object|string $class      Class name (fully-qualified) or object
 * @param string        $interface  Fully-qualified interface name
 *
 * @return bool
 * @throws InvalidArgumentException  If an invalid class name is passed
 */
function implementsInterface(object|string $class, string $interface): bool
{
    if (is_string($class) && ! class_exists($class)) {
        throw new InvalidArgumentException("Class $class not found");
    }

    return in_array($interface, class_implements($class));
}

function rcollect(mixed $items)
{
    return collect($items)->recursive();
}

/******************************************************************************
 *** Enum Tools ***************************************************************
 *****************************************************************************/

/**
 * Pick a random value from a native Enum.
 *
 * @param string $enumClass  FQN of an enum class
 *
 * @return UnitEnum|null  A random Enum item (null if the Enum is empty)
 * @throws InvalidArgumentException  If the Enum class is invalid
 */
function randEnumValue(string $enumClass): ?UnitEnum
{
    if (! enum_exists($enumClass)) {
        throw new InvalidArgumentException("$enumClass is not a valid Enum class name");
    }

    $values = $enumClass::cases();

    return $values ? $values[array_rand($values)] : null;
}
