<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('code', 2)->comment('ISO-639-1 root code, e.g. "en"');
            $table->string('subcode', 2)->nullable()->comment('ISO-639-1 region subcode, e.g. "GB"');
            $table->string('name')->comment('ISO-639-1 Language base name, e.g. "English"');
            $table->string('region')->nullable()->comment('ISO-639-1 Region, e.g. "GB" (ommitted for "Standard")');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
};
