<?php

use App\Enums\WordType;
use App\Models\Language;
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
        Schema::create('words', function (Blueprint $table) {
            $table->id();
            $table->string('word');
            $table->foreignIdFor(Language::class)->constrained()->cascadeOnDelete();
            $table->enum('type', collect(WordType::cases())->map->value->all());
            $table->string('meaning')->nullable()->comment('Approximate English meaning');
            $table->timestamps();

            $table->unique(['word', 'language_id', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('words');
    }
};
