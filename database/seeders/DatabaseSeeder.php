<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->seedLukeSkywalker();

        $this->call([
            CategorySeeder::class,
            // UserSeeder::class,
            LanguageSeeder::class,
            // CourseSeeder::class,
            // UnitSeeder::class,
            // LessonSeeder::class,
            // LearnableSeeder::class,
            // TranslationSeeder::class,
            // ExerciseTypeSeeder::class,
            // ExerciseSeeder::class,
        ]);
    }

    private function seedLukeSkywalker()
    {
        if (User::whereName('Luke Skywalker')->doesntExist()) {
            User::factory()->create([
                'name'  => 'Luke Skywalker',
                'email' => 'luke@jedi.com',
            ]);
        }
    }
}
