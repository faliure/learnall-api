<?php

namespace Database\Factories;

use App\Enums\CefrLevel;
use App\Models\Course;
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
        do {
            $lang1 = Language::inRandomOrder()->first()->id;
            $lang2 = Language::where('language_id', '!=', $lang1)->inRandomOrder()->first()->id;
        } while (Course::where([
            'language_id'   => $lang1,
            'from_language' => $lang2,
        ])->exists());

        return [
            'language_id'   => $lang1,
            'from_language' => $lang2,
            'cefr_level'    => randEnumValue(CefrLevel::class),
            'enabled'       => true,
        ];
    }
}
