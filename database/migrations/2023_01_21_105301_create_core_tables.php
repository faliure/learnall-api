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
            $table->string('code', 2)->unique()->comment('ISO-639-1 root code, e.g. "en"');
            $table->string('name')->unique()->comment('ISO-639-1 Language base name, e.g. "English"');
            $table->string('flag', 3)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 10);
            $table->string('cefr_level', 2)->default('A0');
            $table->boolean('enabled')->default(false);
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->foreignId('from_language')->constrained('languages')->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['from_language', 'language_id']);
        });

        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('enabled')->default(false);
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['course_id', 'name']);
            $table->unique(['course_id', 'slug']);
        });

        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('enabled')->default(false);
            $table->foreignId('level_id')->constrained()->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['level_id', 'name']);
            $table->unique(['level_id', 'slug']);
        });

        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('enabled')->default(false);
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['unit_id', 'name']);
            $table->unique(['unit_id', 'slug']);
        });

        Schema::create('exercise_types', function (Blueprint $table) {
            $table->id();
            $table->string('type', 32)->unique();
            $table->boolean('requires_listening')->default(false);
            $table->boolean('requires_speaking')->default(false);
            $table->boolean('requires_target_keyboard')->default(false);
            $table->string('description');
            $table->json('spec');
            $table->boolean('enabled')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('description')->nullable();
            $table->json('definition')->nullable();
            $table->boolean('enabled')->default(false);
            $table->foreignId('type_id')->constrained('exercise_types')->cascadeOnDelete();
            $table->foreignId('lesson_id')->constrained()->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('learnables', function (Blueprint $table) {
            $table->id();
            $table->string('learnable');
            $table->string('normalized')->nullable();
            $table->string('part_of_speech', 32)->nullable();
            $table->string('source', 32)->nullable();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['language_id', 'learnable', 'part_of_speech']);

            $table->charset   = 'utf8';
            $table->collation = 'utf8_bin';
        });

        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->string('translation');
            $table->boolean('authoritative')->nullable()->comment('TRUE/NULL, required for uniqueness');
            $table->boolean('is_regex')->default(false);
            $table->boolean('enabled')->default(false);
            $table->foreignId('learnable_id')->constrained()->cascadeOnDelete();
            $table->foreignId('language_id')->constrained()->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique([
                'learnable_id',
                'language_id',
                'authoritative',
            ], 'authoritative_unique');

            $table->charset   = 'utf8';
            $table->collation = 'utf8_bin';
        });

        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->boolean('enabled')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        /**********************************************************************
         *** RELATIONS ********************************************************
         *********************************************************************/

        Schema::create('course_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['course_id', 'user_id']);
        });

        Schema::create('exercise_learnable', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exercise_id')->constrained()->cascadeOnDelete();
            $table->foreignId('learnable_id')->constrained()->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('learnable_learnable', function (Blueprint $table) {
            $table->id();
            $table->string('relation_type')->nullable();
            $table->foreignId('learnable_id')->constrained()->cascadeOnDelete();
            $table->foreignId('related_to')->constrained('learnables')->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['learnable_id', 'related_to']);
        });

        Schema::create('categorizables', function (Blueprint $table) {
            $table->id();
            $table->morphs('categorizable');
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('levels');
        Schema::dropIfExists('units');
        Schema::dropIfExists('lessons');
        Schema::dropIfExists('exercise_types');
        Schema::dropIfExists('exercises');
        Schema::dropIfExists('learnables');
        Schema::dropIfExists('translations');
        Schema::dropIfExists('categories');

        Schema::dropIfExists('course_user');
        Schema::dropIfExists('exercise_learnable');
        Schema::dropIfExists('learnable_learnable');
        Schema::dropIfExists('categorizables');

        Schema::enableForeignKeyConstraints();
    }
};
