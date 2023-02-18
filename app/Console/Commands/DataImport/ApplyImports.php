<?php

namespace App\Console\Commands\DataImport;

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

class ApplyImports extends Command
{
    use TsvTools;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:apply';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Learnables, Translations and Categories from scrapped data';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // $this->storeDuomeImports();

        $this->storeDuolingoImports();

        return Command::SUCCESS;
    }

    protected function storeDuomeImports(): void
    {
        $pairs = collect(File::glob(database_path('data/duome/*.json')));

        $this->info(
            "Importing {$pairs->count()} pairs: "
            . conjunction($pairs->map(fn (string $path) => basename($path, '.json')))
            . '...' . PHP_EOL
        );

        $pairs->each($this->storeDuomePair(...));
    }

    protected function storeDuomePair(string $path): void
    {
        $this->info('Importing ' . basename($path) . '...');

        $languageMap = Language::pluck('id', 'code');

        [ $fromCode, $toCode ] = explode('-', basename($path, '.json'));

        collect(readJsonFile($path))->each(
            fn (array $item) => DB::transaction(
                fn () => $this->createDuomeLearnable($item, $languageMap, $fromCode, $toCode)
            )
        );
    }

    protected function createDuomeLearnable(array $item, Collection $languageMap, string $fromCode, string $toCode): void
    {
        $learnable = Learnable::firstOrCreate([
            'learnable'      => $item['learnable'],
            'part_of_speech' => PartOfSpeech::tryFrom(strtolower($item['partOfSpeech'])),
            'language_id'    => $languageMap[ $toCode ],
        ], [
            'normalized' => $item['normalized'],
            'source'     => 'Duome',
        ]);

        $category = ucwords(trim(preg_replace('#[\W_]+#', ' ', $item['category'])));

        $learnable->categorizeAs(Category::firstOrCreate([
            'slug' => Str::slug($category),
        ], [
            'name' => $category,
        ]));

        collect(explode(',', $item['translation'] ?? ''))
            ->map(trim(...))
            ->filter()
            ->each(fn ($translation, $index) => Translation::firstOrCreate([
                'learnable_id' => $learnable->id,
                'language_id'  => $languageMap[ $fromCode ],
                'translation'  => $translation,
            ], [
                'authoritative' => ($index === 0) ?: null,
                'enabled'       => true,
            ]));
    }

    protected function storeDuolingoImports(): void
    {
        $paths = collect(File::glob(database_path('data/duolingo/*.tsv')));

        $this->info(
            "Importing Duolingo lexemes from {$paths->count()} languages: "
            . conjunction($paths->map(fn (string $path) => basename($path, '.tsv')))
            . '...' . PHP_EOL
        );

        $paths->each(fn ($paths) => $this->storeDuolingoLanguageLexemes($paths));
    }

    protected function storeDuolingoLanguageLexemes(string $path): void
    {
        $this->info('Importing ' . basename($path) . '...');

        $languageCode = basename($path, '.tsv');
        $languageId   = Language::firstWhere('code', $languageCode)->id;

        collect($this->importTsv($path))->each(
            fn (array $item) => DB::transaction(
                fn () => Learnable::firstOrCreate([
                    'learnable'      => $item['learnable'],
                    'part_of_speech' => PartOfSpeech::tryFrom(strtolower($item['partOfSpeech'])),
                    'language_id'    => $languageId,
                ], [
                    'normalized' => $item['normalized'],
                    'source'     => 'Duolingo',
                ])
            )
        );
    }
}
