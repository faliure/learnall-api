<?php

namespace Database\Factories;

use App\Extensions\Model;
use Database\Factories\Traits\CanBeDisabled;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ExerciseType>
 */
class ExerciseTypeFactory extends Factory
{
    use CanBeDisabled;

    /**
     * Define the model's default state.
     */
    public function definition(): array
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

    /**
     * Configure the model factory.
     */
    public function configure(): self
    {
        Model::disableGlobalScopes();

        return $this;
    }
}
