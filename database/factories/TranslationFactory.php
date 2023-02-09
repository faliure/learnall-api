<?php

namespace Database\Factories;

use App\Models\Language;
use App\Models\Learnable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $enabled       = $this->faker->boolean(80);
        $authoritative = $this->faker->boolean();

        return [
            'translation'   => $this->faker->sentence(),
            'learnable_id'  => Learnable::inRandomOrder()->first()->id ?? Learnable::factory(),
            'language_id'   => Language::inRandomOrder()->first()->id ?? Language::factory(),
            'authoritative' => $authoritative,
            'is_regex'      => $authoritative ? false : $this->faker->boolean(),
            'enabled'       => $enabled,
            'enabled_at'    => $enabled ? now() : null,
        ];
    }
}
