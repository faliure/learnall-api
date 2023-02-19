<?php

namespace Database\Factories;

use App\Extensions\Model;
use App\Models\Language;
use App\Models\Lesson;
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
            'language_id' => Language::rand()->id,
            'name'        => $this->faker->sentence(2),
            'description' => $this->faker->sentence(),
            'enabled'     => true,
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): self
    {
        Model::disableGlobalScopes();

        return $this->afterCreating(function (Unit $unit) {
            $lessons = Lesson::factory()->count(5)->create([
                'language_id' => $unit->language_id,
            ]);

            $unit->lessons()->sync($lessons->pluck('id'));
        });
    }
}
