<?php

namespace Database\Factories;

use App\Extensions\Model;
use App\Models\Language;
use App\Models\Learnable;
use Database\Factories\Traits\CanBeDisabled;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    use CanBeDisabled;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $learnable = Learnable::rand();
        $language  = Language::rand('id', '!=', $learnable->id);

        return [
            'translation'   => $this->faker->sentence(),
            'learnable_id'  => $learnable->id,
            'language_id'   => $language->id,
            'authoritative' => false,
            'is_regex'      => $this->faker->boolean(),
            'enabled'       => true,
        ];
    }

    public function authoritative()
    {
        return $this->state(fn ($attributes) => [
            'authoritative' => true,
            'is_regex'      => false,
        ]);
    }

    /**
     * Configure the model factory.
     */
    public function configure(): self
    {
        Model::disableGlobalScopes();

        return $this;
    }
}
