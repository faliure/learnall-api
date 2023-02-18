<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait ImportsDumps
{
    protected function importDump(string $path)
    {
        Schema::disableForeignKeyConstraints();

        $this->extractCommands($path)->each(DB::unprepared(...));

        Schema::enableForeignKeyConstraints();

        gc_collect_cycles();
    }

    private function readDump(string $path)
    {
        if ('gz' === pathinfo($path, PATHINFO_EXTENSION)) {
            return join("\n", gzfile($path));
        }

        return file_get_contents($path);
    }

    private function extractCommands(string $path): Collection
    {
        return collect(explode(";\n", $this->readDump($path)))
            ->map(fn ($command) => preg_replace('#/\*.+?\*/#', '', $command))
            ->map(fn ($command) => preg_replace('#^\#.+?\n#', '', $command))
            ->map(fn ($command) => trim($command))
            ->filter();
    }
}
