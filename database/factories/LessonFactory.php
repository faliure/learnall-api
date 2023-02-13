<?php

namespace Database\Factories;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lesson>
 */
class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'        => $this->faker->sentence(3),
            'description' => $this->faker->sentence(),
            'motivation'  => $this->faker->sentence(),
            'language_id' => Language::inRandomOrder()->first()->id ?? Language::factory(),
        ];
    }
}
