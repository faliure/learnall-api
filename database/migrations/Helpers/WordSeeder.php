<?php

namespace Database\Migrations\Helpers;

use App\Models\Language;
use App\Models\Word;

class WordSeeder extends CsvSeeder
{
    /**
     * Seed Words from a CSV file (within database/migrations/batches/words/$batchName.csv).
     */
    public function seed(Language $language, string $batchName, string $delimiter = "|"): void
    {
        $languageId = $language->getKey();
        $pathToCsv = dirname(__DIR__) . '/batches/words/' . $batchName . '.csv';

        $words = self::parseCsv($pathToCsv, $delimiter)
            ->map(fn ($word) => $word + ['language_id' => $languageId])
            ->map(fn ($word) => array_map(fn ($value) => $value ?: null, $word))
            ->all();

        Word::upsert($words, [], []);
    }
};
