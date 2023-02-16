<?php

namespace App\Console\Commands\ImportExport;

use App\Console\Commands\Traits\TsvTools;
use App\Models\Language;
use App\Models\Learnable;
use App\Models\Translation;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ImportTranslations extends Command
{
    use TsvTools;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:translations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Translations from the tsv data files';

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
        $languages->each(
            fn (Language $language) => $languages->each(
                fn (Language $toLanguage) => $this->import($language, $toLanguage)
            )
        );
    }

    public function import(Language $language, Language $toLanguage): void
    {
        $path = database_path("data/{$language->code}-{$toLanguage->code}.tsv");

        if (! file_exists($path)) {
            return;
        }

        $this->importTsv($path)
            ->filter(fn (array $item) => ! empty($item['translation']))
            ->map(fn (array $item) => [ 'type' => $item['type'] ?: null ] + $item)
            ->groupBy(fn (array $item) => $item['learnable'] . '|' . $item['type'])
            ->map->map(fn (array $item) => [
                'translation'   => $item['translation'],
                'authoritative' => $item['authoritative'],
                'is_regex'      => $item['is_regex'],
                'language_id'   => $toLanguage->id,
                'enabled'       => true,
            ])
            ->chunk(200)
            ->each(fn ($chunk) => $this->importChunk($language, $chunk));
    }

    public function importChunk(Language $language, Collection $translations): void
    {
        Learnable::with('translations')
            ->whereLanguageId($language->id)
            ->where(fn ($query) => $translations->keys()->each(
                fn ($key) => $query->orWhere(
                    fn ($query) => $query->where([
                        'learnable' => explode('|', $key)[0],
                        'type'      => explode('|', $key)[1] ?: null,
                    ])
                )
            ))
            ->get()
            ->each(
                fn (Learnable $learnable) => $translations
                    ->get($learnable->learnable . '|' . $learnable->type->value ?? null)
                    ->map(fn ($translation) => Translation::firstOrCreate($translation + [
                        'learnable_id' => $learnable->id,
                    ]))
            );
    }
}
