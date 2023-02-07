<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Sentence;
use Illuminate\Database\Seeder;

class SentenceSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::pluck('name');

        Sentence::factory()->count(10)->create()->each(
            fn (Sentence $sentence) => $categories->random(random_int(0, 3))->each(
                fn (string $categoryName) => $sentence
                    ->categorizeAs($categoryName)
                    ->unsetRelation('categories')
            )
        );
    }
}
