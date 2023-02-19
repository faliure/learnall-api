<?php

namespace Database\Factories;

use App\Extensions\Model;
use App\Models\Category;
use App\Models\Exercise;
use App\Models\Learnable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name'        => $this->faker->unique(true)->sentence(3),
            'slug'        => $this->faker->unique(true)->slug(5),
            'description' => $this->faker->sentence(),
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): self
    {
        Model::disableGlobalScopes();

        return $this->afterCreating(function (Category $category) {
            $category->learnables()->attach(
                Learnable::inRandomOrder()->take(5)->pluck('id')
            );

            $category->exercises()->attach(
                Exercise::inRandomOrder()->take(10)->pluck('id')
            );
        });
    }
}
