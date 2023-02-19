<?php

namespace App\Console\Commands\DataSeeding;

use App\Models\Course;
use App\Models\Exercise;
use App\Models\ExerciseType;
use App\Models\Language;
use App\Models\Lesson;
use App\Models\Level;
use App\Models\Unit;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use InvalidArgumentException;

class SeedCourseSpecs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'spec:courses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Courses sub-items, from their stored specs';

    /**
     * Mapping from Language code to id.
     */
    protected Collection $languageMap;

    /**
     * Mapping from ExerciseType type to id.
     */
    protected Collection $exerciseTypeMap;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        // TODO: add JSON Schema Validation
        // @see https://github.com/justinrainbow/json-schema

        $this->languageMap     = Language::pluck('id', 'code');
        $this->exerciseTypeMap = ExerciseType::pluck('id', 'type');

        $paths = collect(File::glob(database_path('data/courseSpecs/*.json')));

        $this->info(
            "Creating structure for {$paths->count()} courses: "
            . conjunction($paths->map(fn (string $path) => basename($path, '.json')))
            . '...' . PHP_EOL
        );

        $paths->each($this->processSpec(...));
    }

    protected function processSpec(string $path): void
    {
        $this->info('Processing ' . basename($path) . '...');

        [ $fromCode, $toCode ] = explode('-', basename($path, '.json'));

        $course = Course::firstWhere([
            'language_id'   => $this->languageMap[ $toCode ],
            'from_language' => $this->languageMap[ $fromCode ],
        ]);

        $this->buildCourse($course, readJsonFile($path));
    }

    protected function buildCourse(Course $course, array $courseSpec): void
    {
        collect($courseSpec)->each(
            fn (array $levelSpec) => $this->buildLevel($course, $levelSpec)
        );
    }

    protected function buildLevel(Course $course, array $spec): void
    {
        $this->enforceSpecHas($spec, 'name', 'Level');

        $level = Level::updateOrCreate([
            'course_id' => $course->id,
            'name'      => $spec['name'],
        ], [
            'description' => $spec['description'] ?? null,
            'enabled'     => $spec['enabled'] ?? ! empty($spec['units']),
        ]);

        collect($spec['units'] ?? [])->each(
            fn (array $unitSpec) => $this->buildUnit($level, $unitSpec)
        );
    }

    protected function buildUnit(Level $level, array $spec)
    {
        $this->enforceSpecHas($spec, 'name', 'Unit');

        $unit = Unit::updateOrCreate([
            'level_id' => $level->id,
            'name'     => $spec['name'],
        ], [
            'description' => $spec['description'] ?? null,
            'enabled'     => $spec['enabled'] ?? ! empty($spec['lessons']),
        ]);

        collect($spec['lessons'] ?? [])->each(
            fn (array $lessonSpec) => $this->buildLesson($unit, $lessonSpec)
        );
    }

    protected function buildLesson(Unit $unit, array $spec)
    {
        $this->enforceSpecHas($spec, 'name', 'Lesson');

        $lesson = Lesson::updateOrCreate([
            'unit_id' => $unit->id,
            'name'    => $spec['name'],
        ], [
            'description' => $spec['description'] ?? null,
            'enabled'     => $spec['enabled'] ?? ! empty($spec['exercises']),
        ]);

        collect($spec['exercises'] ?? [])->each(
            fn (array $exerciseSpec) => $this->buildExercise($lesson, $exerciseSpec)
        );
    }

    protected function buildExercise(Lesson $lesson, array $spec)
    {
        $this->enforceSpecHas($spec, 'type', 'Exercise');
        $this->enforceSpecHas($spec, 'definition', 'Exercise');

        $lesson = Exercise::updateOrCreate([
            'lesson_id'   => $lesson->id,
            'type'        => $this->exerciseTypeMap[ $spec['type'] ],
            'definition'  => $spec['definition'] ?? null,
        ], [
            'description' => $spec['description'] ?? null,
            'enabled'     => $spec['enabled'] ?? true,
        ]);
    }

    protected function enforceSpecHas(array $spec, string $key, string $specType): void
    {
        if (empty($spec[$key])) {
            throw new InvalidArgumentException("A $specType Spec must have a `$key`");
        }
    }
}
