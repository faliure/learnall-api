<?php

namespace Database\Factories;

use App\Extensions\Model;
use App\Models\Exercise;
use App\Models\ExerciseType;
use App\Models\Language;
use App\Models\Learnable;
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
            'type_id'     => ExerciseType::rand()->id,
            'definition'  => [$this->faker->word() => $this->faker->sentence()],
            'language_id' => Language::rand()->id,
            'description' => $this->faker->sentence(),
            'motivation'  => $this->faker->sentence(),
            'enabled'     => true,
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
