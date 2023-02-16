<?php

namespace App\Console\Commands\Traits;

use Illuminate\Support\Collection;
use JamesGordo\CSV\Parser;

trait TsvTools
{
    /**
     * Import a tsv file's contents.
     */
    protected function importTsv(string $path): Collection
    {
        $parser = new Parser();
        $parser->setCsv($path);
        $parser->setDelimeter("\t");
        $parser->parse();

        return rcollect($parser->all())->map->map(fn ($value) => trim($value))->map->toArray();
    }

    /**
     * Import a tsv file's contents.
     */
    protected function exportTsv(string $path): Collection
    {
        // TODO
        return collect();
    }
}
