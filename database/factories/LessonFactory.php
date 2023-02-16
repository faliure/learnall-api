<?php

namespace Database\Factories;

use App\Extensions\Model;
use App\Models\Exercise;
use App\Models\ExerciseType;
use App\Models\Language;
use App\Models\Learnable;
use App\Models\Lesson;
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
            'name'        => $this->faker->sentence(3),
            'description' => $this->faker->sentence(),
            'motivation'  => $this->faker->sentence(),
            'enabled'     => true,
            'language_id' => Language::rand()->id,
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): self
    {
        Model::disableGlobalScopes();

        return $this->afterCreating(function (Lesson $lesson) {
            $exercises = Exercise::factory()
                ->count(10)
                ->create([ 'language_id' => $lesson->language_id ])
                ->each(fn ($exercise) => $exercise->learnables()->sync(
                    Learnable::rand('language_id', $lesson->language_id)?->id
                ));

            $lesson->exercises()->sync($exercises->pluck('id'));
        });
    }
}
