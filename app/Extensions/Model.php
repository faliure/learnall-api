<?php

namespace App\Extensions;

use App\Models\Traits\LazyRelations;
use App\Models\Validators\Validator;
use Faliure\Resourceable\Contracts\Resourceable;
use Faliure\Resourceable\Traits\HasResources;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel implements Resourceable
{
    use HasFactory;
    use HasResources;
    use LazyRelations;
    use Validator;

    protected $guarded = [];

    protected static $enableGlobalScopes = true;

    public static function enableGlobalScopes(): void
    {
        static::$enableGlobalScopes = true;
    }

    public static function disableGlobalScopes(): void
    {
        static::$enableGlobalScopes = false;
    }

    public function getGlobalScopes(): array
    {
        return static::$enableGlobalScopes
            ? parent::getGlobalScopes()
            : [];
    }

    public static function rand(...$filters): ?static
    {
        return static::query()
            ->when($filters, fn ($q, $filters) => $q->where(...$filters))
            ->inRandomOrder()
            ->first();
    }
}
