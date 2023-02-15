<?php

namespace App\Extensions;

use Illuminate\Database\Eloquent\Model;
use UnexpectedValueException;

abstract class CrudController extends Controller
{
    /**
     * Model FQN, when the Controller is not named {$model}Controller.
     */
    protected string $model;

    public function __construct()
    {
        $this->authorizeResource($this->getModel());

        // https://laracasts.com/series/laravel-8-from-scratch/episodes/69
        // $this->authorize('collaborator');

        $this->middleware('throttle:60,1')->only(['store', 'update', 'destroy']);
    }

    /**
     * Get the FQN class of the Model handled by this Controller.
     */
    public function getModel(): string
    {
        return $this->model ?? ($this->model = $this->inferModel());
    }

    /**
     * Try to infer the underlying Model this CRUD Controller is for.
     */
    private function inferModel(): string
    {
        $controller = class_basename(static::class);
        $modelName  = preg_replace('#Controller$#', '', $controller);
        $modelClass = 'App\\Models\\' . $modelName;

        if (! is_subclass_of($modelClass, Model::class)) {
            throw new UnexpectedValueException(
                "The Model for CRUD Controller {$controller} is invalid. " .
                "Make sure the name of the Controller follows standards (" .
                "{Model}Controller) or explicitly define the @model property."
            );
        }

        return $modelClass;
    }
}
