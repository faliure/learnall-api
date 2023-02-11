<?php

use App\Models\Language;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->string('flag', 3)->nullable();

            $table->unique(['code']);
        });

        Language::upsert([
            [
                'code'    => 'en',
                'name'    => 'not-updated',
                'flag'    => 'US',
            ],
            [
                'code'    => 'es',
                'name'    => 'not-updated',
                'flag'    => 'ES',
            ],
            [
                'code'    => 'fr',
                'name'    => 'not-updated',
                'flag'    => 'FR',
            ],
            [
                'code'    => 'pt',
                'name'    => 'not-updated',
                'flag'    => 'BR',
            ],
            [
                'code'    => 'ua',
                'name'    => 'not-updated',
                'flag'    => 'UA',
            ],
            [
                'code'    => 'it',
                'name'    => 'not-updated',
                'flag'    => 'IT',
            ],
        ], [ 'code' ], [ 'flag' ]);

        Schema::table('languages', function (Blueprint $table) {
            $table->dropUnique(['code']);
        });

        DB::statement('ALTER TABLE `languages` AUTO_INCREMENT = 1');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('languages', function (Blueprint $table) {
            $table->dropColumn('flag');
        });
    }
};
