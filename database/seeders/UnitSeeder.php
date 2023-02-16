<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::rand([ 'enabled' => true ]);

        Unit::factory()->count(20)->create([
            'language_id' => $course->language_id,
        ])->each(fn ($unit) => $unit->courses()->attach($course));
    }
}
