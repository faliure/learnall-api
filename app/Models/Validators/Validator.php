<?php

namespace App\Models\Validators;

use App\Contracts\Validation\ModelValidator;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Support\Facades\Validator as LaravelValidator;

trait Validator
{
    protected ?ModelValidator $validator = null;

    protected array $validationRules = [];

    protected ?MessageBag $validationErrors = null;

    private static array $handledEvents = [
        'creating',
        'updating',
        'deleting',
        'saving',
        'restoring',
        'replicating',
    ];

    public function initializeValidator(): void
    {
        $this->validator = $this->getValidator();

        $this->setValidatorEventHandlers();
    }

    public function getValidationRules(): array
    {
        if (is_callable([$this->validator, 'rules'])) {
            return call_user_func([$this->validator, 'rules']);
        }

        return $this->validator->rules ?? $this->validationRules ?? [];
    }

    public function validationErrors(): ?MessageBag
    {
        return $this->validationErrors;
    }

    private function getValidator(): ?ModelValidator
    {
        $validatorClass = '\\App\\Models\\Validators\\' . class_basename(self::class) . 'Validator';

        if (! class_exists($validatorClass)) {
            return null;
        }

        return new $validatorClass($this);
    }

    private function setValidatorEventHandlers(): void
    {
        foreach (self::$handledEvents as $event) {
            if (is_callable([$this->validator, $event])) {
                static::$event(fn ($model) => $this->validator->$event($model));
            }
        }

        $validationRules = $this->getValidationRules();

        if ($validationRules && ! is_callable([$this->validator, 'saving'])) {
            static::saving(fn () => $this->validate($validationRules));
        }
    }

    private function validate(array $rules): bool
    {
        $validator = LaravelValidator::make($this->attributes, $rules);

        if ($validator->fails()) {
            $this->validationErrors = $validator->errors();

            return false;
        }

        return true;
    }
}
