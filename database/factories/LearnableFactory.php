<?php

namespace Database\Factories;

use App\Enums\LearnableType;
use App\Extensions\Model;
use App\Models\Course;
use App\Models\Language;
use App\Models\Learnable;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Throwable;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Learnable>
 */
class LearnableFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'type'        => randEnumValue(LearnableType::class),
            'learnable'   => $this->faker->unique(true)->sentence(),
            'language_id' => Language::rand()->id,
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): self
    {
        Model::disableGlobalScopes();

        return $this->afterCreating(function (Learnable $learnable) {
            $sequence = Course::inRandomOrder()
                ->where('language_id', $learnable->language_id)
                ->take(2)
                ->pluck('from_language')
                ->map(fn (int $id) => [ 'language_id' => $id ]);

            Translation::factory()
                ->count($sequence->count())
                ->sequence(...$sequence)
                ->authoritative()
                ->create([ 'learnable_id' => $learnable->id ]);

            $related = Learnable::inRandomOrder()
                ->where('id', '!=', $learnable->id)
                ->where('language_id', $learnable->language_id)
                ->whereNotIn('id', $learnable->related()->select('related_to'))
                ->take(random_int(0, 2))
                ->pluck('id')
                ->toArray();

            $learnable->related()->attach($related);
        });
    }
}
