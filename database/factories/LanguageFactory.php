<?php

namespace Database\Factories;

use App\Extensions\Model;
use App\Models\Course;
use App\Models\Exercise;
use App\Models\ExerciseType;
use App\Models\Language;
use App\Models\Learnable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Language>
 */
class LanguageFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $hasRegion = $this->faker->boolean(30);

        return [
            'code'    => $this->faker->unique(true)->lexify('??'),
            'name'    => $this->faker->word(),
            'region'  => $hasRegion ? $this->faker->word() : null,
            'flag'    => $this->faker->randomElement(['US', 'CA', 'UA', 'FR', 'BR', 'UY']),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): self
    {
        Model::disableGlobalScopes();

        return $this->afterCreating(function (Language $language) {
            $sequence = Language::inRandomOrder()
                ->where('id', '!=', $language->id)
                ->take(2)
                ->pluck('id');

            Course::factory()
                ->count($sequence->count())
                ->sequence(...$sequence->map(fn (int $id) => [ 'language_id' => $id ]))
                ->create([ 'from_language' => $language->id ]);

            Course::factory()
                ->count($sequence->count())
                ->sequence(...$sequence->map(fn (int $id) => [ 'from_language' => $id ]))
                ->create([ 'language_id' => $language->id ]);

            Learnable::factory()
                ->count(10)
                ->create([ 'language_id' => $language->id ]);

            Learnable::factory()
                ->count(10)
                ->create([ 'language_id' => $sequence->get(0) ]);

            Learnable::factory()
                ->count(10)
                ->create([ 'language_id' => $sequence->get(1) ]);
        });
    }
}
