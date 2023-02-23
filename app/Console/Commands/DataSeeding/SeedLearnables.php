<?php

namespace App\Console\Commands\DataSeeding;

use App\Console\Commands\Traits\TsvTools;
use App\Enums\PartOfSpeech;
use App\Models\Category;
use App\Models\Language;
use App\Models\Learnable;
use App\Models\Translation;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SeedLearnables extends Command
{
    use TsvTools;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:learnables {--s|source=learnall}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Learnables, Translations and Categories from json specs';

    /**
     * The source of this learnables (duolingo, duome, learnall).
     */
    protected string $source;

    /**
     * Mapping from Language code to id.
     */
    protected Collection $languageMap;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->source = strtolower($this->option('source'));

        $this->languageMap = Language::pluck('id', 'code');

        $this->storeLearnables();

        return Command::SUCCESS;
    }

    protected function storeLearnables(): void
    {
        $paths = collect(File::glob(database_path("data/{$this->source}/*.json")));

        $this->info(
            "Importing {$paths->count()} pairs: "
            . conjunction($paths->map(fn (string $path) => basename($path, '.json')))
            . '...' . PHP_EOL
        );

        $paths->each($this->storeLearnablesForCourse(...));
    }

    protected function storeLearnablesForCourse(string $path): void
    {
        $this->info('Importing Learnables for Course ' . basename($path) . '...');

        [ $fromCode, $toCode ] = explode('-', basename($path, '.json'));

        collect(readJsonFile($path))->each(
            fn (array $item) => DB::transaction(
                fn () => $this->createLearnable($item, $fromCode, $toCode)
            )
        );
    }

    protected function createLearnable(array $item, string $fromCode, string $toCode): void
    {
        $learnable = Learnable::firstOrCreate([
            'learnable'      => $item['learnable'],
            'part_of_speech' => PartOfSpeech::tryFrom(strtolower($item['partOfSpeech'])),
            'language_id'    => $this->languageMap[ $toCode ],
        ], [
            'normalized' => $item['normalized'],
            'source'     => ucwords($this->source),
        ]);

        $category = ucwords(trim(preg_replace('#[\W_]+#', ' ', $item['category'])));

        $learnable->categorizeAs(Category::firstOrCreate([
            'slug' => Str::slug($category),
        ], [
            'name' => $category,
        ]));

        collect(explode(',', $item['translation'] ?? ''))
            ->map(fn ($translation) => trim($translation))
            ->filter()
            ->each(fn ($translation, $index) => Translation::firstOrCreate([
                'learnable_id' => $learnable->id,
                'language_id'  => $this->languageMap[ $fromCode ],
                'translation'  => $translation,
            ], [
                'authoritative' => ($index === 0) ?: null,
                'enabled'       => true,
            ]));
    }
}
