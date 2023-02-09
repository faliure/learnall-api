<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CourseSeeder::class,
            ExerciseSeeder::class,
            CategorySeeder::class,
        ]);
    }
}
