<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Language;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        do {
            $lang1 = Language::rand()->id;
            $lang2 = Language::rand('id', '!=', $lang1)->id;
        } while (Course::where([
            'language_id'   => $lang1,
            'from_language' => $lang2,
        ])->exists());

        return Course::factory()->create([
            'language_id'   => $lang1,
            'from_language' => $lang2,
        ]);
    }
}
