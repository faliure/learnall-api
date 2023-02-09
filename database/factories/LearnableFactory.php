<?php

namespace Database\Factories;

use App\Enums\LearnableType;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Learnable>
 */
class LearnableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'type'        => randEnumValue(LearnableType::class),
            'learnable'   => $this->faker->word(),
            'language_id' => Language::inRandomOrder()->first()->id ?? Language::factory(),
        ];
    }
}
