<?php

use App\Traits\ImportsDumps;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    use ImportsDumps;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->importDump(database_path('dumps/seed-3-categories.sql.gz'));
    }
};
