<?php

namespace Database\Factories;

use App\Models\Exercise;
use App\Models\ExerciseType;
use App\Models\Language;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exercise>
 */
class ExerciseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type_id'     => ExerciseType::inRandomOrder()->first()->id ?? ExerciseType::factory(),
            'definition'  => [$this->faker->word() => $this->faker->sentence()],
            'language_id' => Language::inRandomOrder()->first()->id ?? Language::factory(),
            'description' => $this->faker->sentence(),
            'motivation'  => $this->faker->sentence(),
            'enabled'     => true,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Exercise $exercise) {
            $constraint = ['language_id' => $exercise->language_id];

            $unit = Unit::where($constraint)->inRandomOrder()->first()
                ?? Unit::factory()->create($constraint);

            // if (random_int(0, 1)) { // Throw a coin: attach or create new Lesson?
            //     $lesson = $unit->lessons()->inRandomOrder()->first();
            // }

            // $exercise->lessons()->attach(
            //     ($lesson ?? Lesson::factory()->create([ 'unit_id' => $unit->id ]))->id
            // );
        });
    }
}
