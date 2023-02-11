<?php

use App\Models\Course;
use App\Models\Language;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();
        Course::truncate();
        Schema::enableForeignKeyConstraints();

        $languages = Language::pluck('id', 'code');

        Course::insert([
            [
                'from_language' => $languages['en'],
                'language_id'   => $languages['ua'],
                'enabled'       => true,
            ],
            [
                'from_language' => $languages['ua'],
                'language_id'   => $languages['en'],
                'enabled'       => false,
            ],
            [
                'from_language' => $languages['es'],
                'language_id'   => $languages['en'],
                'enabled'       => false,
            ],
            [
                'from_language' => $languages['en'],
                'language_id'   => $languages['es'],
                'enabled'       => false,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
