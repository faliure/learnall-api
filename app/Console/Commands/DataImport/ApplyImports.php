<?php

namespace App\Console\Commands\DataImport;

use App\Console\Commands\Traits\TsvTools;
use App\Enums\PartOfSpeech;
use App\Models\Language;
use App\Models\Learnable;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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
     * Mapping from Language code to id.
     */
    protected Collection $languageMap;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->languageMap = Language::pluck('id', 'code');

        $this->call('seed:learnables', [ '-s' => 'duome' ]);

        $this->storeDuolingoImports();

        return Command::SUCCESS;
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
