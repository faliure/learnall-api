<?php

namespace Database\Factories;

use App\Enums\CefrLevel;
use App\Extensions\Model;
use App\Models\Course;
use App\Models\Language;
use App\Models\Unit;
use Database\Factories\Traits\CanBeDisabled;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    use CanBeDisabled;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'cefr_level'    => randEnumValue(CefrLevel::class),
            'enabled'       => true,
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): self
    {
        Model::disableGlobalScopes();

        return $this->afterCreating(function (Course $course) {
            $units = Unit::factory()->count(5)->create([
                'language_id' => $course->language_id,
            ]);

            $course->units()->sync($units->pluck('id'));
        });
    }
}
