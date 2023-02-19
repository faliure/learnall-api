<?php

use App\Models\Course;
use App\Models\ExerciseType;
use App\Models\Language;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->seedLanguages();

        $this->seedCourses();

        $this->seedExerciseTypes();
    }

    private function seedLanguages(): void
    {
        $languages = readJsonFile(database_path('data/languages.json'));

        Language::upsert($languages, [ 'code' ], [ 'name' ]);
    }

    public function seedCourses(): void
    {
        $languages = Language::pluck('id', 'code');

        $enabled = [
            ['en', 'es'],
            ['en', 'uk'],
            ['es', 'en'],
            ['es', 'uk'],
        ];

        $courses = collect(File::glob(database_path('data/duome/*.json')))
            ->map(fn (string $path) => explode('-', basename($path, '.json')))
            ->map(fn (array $pair) => [
                'from_language' => $languages[ $pair[0] ],
                'language_id'   => $languages[ $pair[1] ],
                'slug'          => $pair[0] . '-' . $pair[1],
                'enabled'       => in_array($pair, $enabled),
            ])
            ->toArray();

        Course::upsert($courses, [ 'language_id', 'from_language', 'slug' ], [ 'enabled' ]);
    }

    private function seedExerciseTypes()
    {
        ExerciseType::upsert(
            readJsonFile(database_path('data/exerciseTypes.json')),
            [ 'type' ],
            [ 'requires_listening', 'requires_speaking', 'requires_target_keyboard', 'description', 'spec' ]
        );
    }
};
