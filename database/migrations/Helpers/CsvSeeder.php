<?php

namespace Database\Migrations\Helpers;

use Illuminate\Support\Collection;
use JamesGordo\CSV\Parser;

class CsvSeeder
{
    protected function parseCsv(string $path, string $delimiter): Collection
    {
        $parser = new Parser();
        $parser->setCsv($path);
        $parser->setDelimeter($delimiter);
        $parser->parse();

        return collect($parser->all())
            ->map(fn ($item) => (array) $item)
            ->map(fn ($item) => array_map('trim', $item));
    }
};
