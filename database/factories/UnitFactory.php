<?php

namespace Database\Factories;

use App\Extensions\Model;
use App\Models\Lesson;
use App\Models\Level;
use App\Models\Unit;
use Database\Factories\Traits\CanBeDisabled;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
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
            'level_id'    => Level::rand()->id,
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): self
    {
        Model::disableGlobalScopes();

        return $this->afterCreating(
            fn (Unit $unit) => $unit->saveMany(
                Lesson::factory()->count(2)->make()
            )
        );
    }
}
