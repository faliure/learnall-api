<?php

namespace Database\Factories;

use App\Models\ExerciseType;
use App\Models\Lesson;
use Database\Factories\Traits\CanBeDisabled;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exercise>
 */
class ExerciseFactory extends Factory
{
    use CanBeDisabled;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'description' => $this->faker->sentence(),
            'definition'  => [$this->faker->word() => $this->faker->sentence()],
            'enabled'     => true,
            'lesson_id'   => Lesson::rand()->id,
            'type_id'     => ExerciseType::rand()->id,
        ];
    }
}
