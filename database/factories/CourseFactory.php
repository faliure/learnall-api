<?php

namespace Database\Factories;

use App\Enums\CefrLevel;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $lang1 = Language::inRandomOrder()->first()->id ?? Language::factory();

        do {
            $lang2 = Language::inRandomOrder()->first()->id ?? Language::factory();
        } while ($lang1 === $lang2);

        return [
            'language_id'   => $lang1,
            'from_language' => $lang2,
            'enabled'       => $this->faker->boolean(90),
            'cefr_level'    => randEnumValue(CefrLevel::class),
        ];
    }
}
