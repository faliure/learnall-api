<?php

namespace App\Console\Commands\ImportExport;

use App\Console\Commands\Traits\TsvTools;
use App\Models\Language;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ImportLearnables extends Command
{
    use TsvTools;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:learnables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Learnables from the tsv data files';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // TODO : check which files were modified after last import,
        //        and only import those languages
        $languages = Language::all();

        DB::transaction(fn () => $this->process($languages));

        return Command::SUCCESS;
    }

    protected function process(Collection $languages): void
    {
        // Set non-null for missing types, to enforce unicity checks
        DB::table('learnables')->whereNull('type')->update(['type' => 'unknown']);

        $languages->each(
            fn (Language $language) => $languages->each(
                fn (Language $toLanguage) => $this->import($language, $toLanguage)
            )
        );

        // Set all missing types back to NULL
        DB::table('learnables')->where('type', 'unknown')->update(['type' => null]);
    }

    public function import(Language $language, Language $toLanguage): void
    {
        $path = database_path("data/{$language->code}-{$toLanguage->code}.tsv");

        if (! file_exists($path)) {
            return;
        }

        $this->importTsv($path)
            ->map(fn ($item) => [
                'learnable'   => $item['learnable'],
                'type'        => $item['type'] ?: 'unknown',
                'language_id' => $language->id,
            ])
            ->unique()
            ->chunk(500)
            ->each(function (Collection $chunk) {
                DB::table('learnables')->insertOrIgnore(
                    $chunk->toArray(),
                    [ 'language_id', 'learnable', 'type' ],
                    [ 'type' ]
                );
            });
    }
}
