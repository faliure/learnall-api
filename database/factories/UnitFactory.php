<?php

namespace Database\Factories;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unit>
 */
class UnitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'language_id' => Language::inRandomOrder()->first()->id ?? Language::factory(),
            'name'        => $this->faker->sentence(2),
            'description' => $this->faker->sentence(),
            'motivation'  => $this->faker->sentence(),
            'enabled'     => true,
        ];
    }
}
