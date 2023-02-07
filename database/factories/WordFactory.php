<?php

namespace Database\Factories;

use App\Enums\WordType;
use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Word>
 */
class WordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'language_id' => Language::factory(),
            'type'        => randEnumValue(WordType::class),
            'word'        => $this->faker->word(),
            'meaning'     => $this->faker->sentence(),
        ];
    }
}
