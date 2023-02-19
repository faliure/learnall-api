<?php

namespace App\Providers;

use App\Models\Exercise;
use App\Models\Learnable;
use App\Models\Lesson;
use App\Models\Level;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();

        Relation::enforceMorphMap([
            'Exercise'  => Exercise::class,
            'Learnable' => Learnable::class,
            'Lesson'    => Lesson::class,
            'Level'     => Level::class,
            'Unit'      => Unit::class,
            'User'      => User::class,
        ]);
    }
}
