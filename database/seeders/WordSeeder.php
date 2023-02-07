<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Word;
use Illuminate\Database\Seeder;

class WordSeeder extends Seeder
{
    public function run()
    {
        $categories = Category::pluck('name');

        Word::factory()->count(10)->create()->each(
            fn (Word $word) => $categories->random(random_int(0, 3))->each(
                fn (string $categoryName) => $word
                    ->categorizeAs($categoryName)
                    ->unsetRelation('categories')
            )
        );
    }
}
