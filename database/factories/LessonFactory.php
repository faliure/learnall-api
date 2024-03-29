<?php

namespace Database\Factories;

use App\Extensions\Model;
use App\Models\Exercise;
use App\Models\Lesson;
use App\Models\Unit;
use Database\Factories\Traits\CanBeDisabled;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    use CanBeDisabled;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name'        => $this->faker->sentence(2),
            'description' => $this->faker->sentence(),
            'enabled'     => true,
            'unit_id'     => Unit::rand()->id,
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): self
    {
        Model::disableGlobalScopes();

        return $this->afterCreating(
            fn (Lesson $lesson) => $lesson->saveMany(
                Exercise::factory()->count(5)->make()
            )
        );
    }
}
