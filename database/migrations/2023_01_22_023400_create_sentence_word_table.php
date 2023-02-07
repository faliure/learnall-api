<?php

use App\Models\Sentence;
use App\Models\Word;
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
        Schema::create('sentence_word', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Sentence::class)->constrained()->cascadeOnDelete();;
            $table->foreignIdFor(Word::class)->constrained()->cascadeOnDelete();;
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
        Schema::dropIfExists('sentence_word');
    }
};
