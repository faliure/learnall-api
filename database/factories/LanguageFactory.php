<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Language>
 */
class LanguageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $hasRegion = $this->faker->boolean(30);

        return [
            'code'    => $this->faker->unique()->lexify('??'),
            'subcode' => $hasRegion ? $this->faker->unique()->lexify('??') : null,
            'name'    => $this->faker->word(),
            'region'  => $hasRegion ? $this->faker->word() : null,
        ];
    }
}
