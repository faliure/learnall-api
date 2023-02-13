<?php

namespace Database\Migrations\Helpers;

use App\Models\Language;
use App\Models\Learnable;
use App\Models\Translation;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LearnableSeeder extends CsvSeeder
{
    /**
     * Seed Learnables from a CSV file (within database/migrations/batches/learnables/$batchName.csv).
     */
    public function seed(Language $toLanguage, string $batchName, string $delimiter = "|"): void
    {
        $pathToCsv = dirname(__DIR__) . '/batches/learnables/' . $batchName . '.csv';

        $firstAvailableLearnableId = Learnable::latest()->first()->id ?? 1;

        $learnables = self::parseCsv($pathToCsv, $delimiter)
            ->map(fn (Collection $learnable, $i) => $learnable->merge([
                'language_id'   => $toLanguage->id,
                'learnable_id'  => $i + $firstAvailableLearnableId,
                'authoritative' => true,
                'is_regex'      => false,
                'enabled'       => true,
            ]));

        $learnableData = $learnables->map->only('learnable', 'type', 'language_id')->toArray();
        DB::table('learnables')->insertOrIgnore($learnableData);

        $translationData = $learnables->map->except('learnable', 'type')->toArray();
        DB::table('translations')->insertOrIgnore($translationData);
    }
};
