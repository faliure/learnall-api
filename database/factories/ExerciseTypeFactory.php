<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExerciseType>
 */
class ExerciseTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type'                     => $this->faker->unique()->word(),
            'requires_listening'       => $this->faker->boolean(),
            'requires_speaking'        => $this->faker->boolean(),
            'requires_target_keyboard' => $this->faker->boolean(),
            'description'              => $this->faker->sentence(),
            'spec'                     => [ $this->faker->word() => $this->faker->sentence() ],
            'enabled'                  => true,
        ];
    }
}
