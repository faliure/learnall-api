<?php

namespace Database\Factories;

use App\Extensions\Model;
use App\Models\Course;
use App\Models\Level;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Level>
 */
class LevelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'        => $this->faker->sentence(2),
            'description' => $this->faker->sentence(),
            'enabled'     => true,
            'course_id'   => Course::rand()->id,
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): self
    {
        Model::disableGlobalScopes();

        return $this->afterCreating(
            fn (Level $level) => $level->saveMany(
                Unit::factory()->count(2)->make()
            )
        );
    }
}
