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
        /**********************************************************************
         *** ENTITIES *********************************************************
         *********************************************************************/

        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('code', 2)->comment('ISO-639-1 root code, e.g. "en"');
            $table->string('subcode', 2)->nullable()->comment('ISO-639-1 region subcode, e.g. "GB"');
            $table->string('name')->comment('ISO-639-1 Language base name, e.g. "English"');
            $table->string('region')->nullable()->comment('ISO-639-1 Region, e.g. "GB" (ommitted for "Standard")');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->foreignId('from_language')->constrained('languages')->cascadeOnDelete();
            $table->boolean('enabled')->default(false);
            $table->string('cefr_level', 2)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('motivation')->nullable();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('motivation')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('exercise_types', function (Blueprint $table) {
            $table->id();
            $table->string('type', 32)->unique();
            $table->boolean('requires_listening')->default(false);
            $table->boolean('requires_speaking')->default(false);
            $table->boolean('requires_target_keyboard')->default(false);
            $table->string('description');
            $table->json('spec');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->json('definition')->nullable();
            $table->foreignId('type_id')->constrained('exercise_types')->cascadeOnDelete();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->string('description')->nullable();
            $table->string('motivation')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('learnables', function (Blueprint $table) {
            $table->id();
            $table->string('learnable');
            $table->string('type', 32);
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['learnable', 'language_id', 'type']);
        });

        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('translation');
            $table->foreignId('learnable_id')->constrained()->cascadeOnDelete();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->boolean('authoritative')->nullable();
            $table->boolean('is_regex')->default(false);
            $table->boolean('enabled')->default(false);
            $table->timestamp('enabled_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique([
                'learnable_id',
                'language_id',
                'enabled',
                'authoritative',
            ], 'authoritative_unique');
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->string('motivation')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        /**********************************************************************
         *** RELATIONS ********************************************************
         *********************************************************************/

        Schema::create('course_unit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->string('motivation')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('lesson_unit', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->string('motivation')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('exercise_lesson', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained()->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->string('motivation')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('exercise_learnable', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained()->cascadeOnDelete();
            $table->foreignId('learnable_id')->constrained()->cascadeOnDelete();
            $table->string('motivation')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('learnable_learnable', function (Blueprint $table) {
            $table->id();
            $table->foreignId('learnable_id')->constrained()->cascadeOnDelete();
            $table->foreignId('related_to')->constrained('learnables')->cascadeOnDelete();
            $table->string('relation_type')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('categorizables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->morphs('categorizable');
            $table->string('motivation')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique([
                'category_id',
                'categorizable_id',
                'categorizable_type'
            ], 'category_categorizable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('languages');
        Schema::dropIfExists('courses');
        Schema::dropIfExists('units');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('exercise_types');
        Schema::dropIfExists('exercises');
        Schema::dropIfExists('learnables');
        Schema::dropIfExists('translations');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('course_unit');
        Schema::dropIfExists('lesson_unit');
        Schema::dropIfExists('exercise_lesson');
        Schema::dropIfExists('exercise_learnable');
        Schema::dropIfExists('learnable_learnable');
        Schema::dropIfExists('categorizables');

        Schema::enableForeignKeyConstraints();
    }
};
