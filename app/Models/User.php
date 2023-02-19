<?php

namespace App\Models;

use App\Models\Traits\Mutators\UserMutators;
use App\Models\Validators\Validator;
use Faliure\Resourceable\Contracts\Resourceable;
use Faliure\Resourceable\Traits\HasResources;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements Resourceable
{
    use HasApiTokens;
    use HasFactory;
    use HasResources;
    use Notifiable;
    use UserMutators;
    use Validator;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'active_course',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class);
    }

    public function activeCourse(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'active_course');
    }
}
