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
            // UserSeeder::class,
            // LevelSeeder::class,
            // UnitSeeder::class,
            // LessonSeeder::class,
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
