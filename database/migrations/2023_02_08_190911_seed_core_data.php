<?php

use App\Models\Course;
use App\Models\ExerciseType;
use App\Models\Language;
use Database\Migrations\Helpers\LearnableSeeder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        $this->seedLanguages();

        $this->seedCourses();

        $this->seedLearnables();

        $this->seedExerciseTypes();
    }

    private function seedLanguages(): void
    {
        Language::upsert([
            [
                'code'    => 'en',
                'subcode' => null,
                'name'    => 'English',
                'region'  => null,
                'flag'    => 'US',
            ],
            [
                'code'    => 'es',
                'subcode' => null,
                'name'    => 'Spanish',
                'region'  => 'Spain',
                'flag'    => 'ES',
            ],
            [
                'code'    => 'fr',
                'subcode' => null,
                'name'    => 'French',
                'region'  => null,
                'flag'    => 'FR',
            ],
            [
                'code'    => 'pt',
                'subcode' => 'br',
                'name'    => 'Portuguese',
                'region'  => 'Brazil',
                'flag'    => 'BR',
            ],
            [
                'code'    => 'it',
                'subcode' => null,
                'name'    => 'Italian',
                'region'  => null,
                'flag'    => 'IT',
            ],
            [
                'code'    => 'uk',
                'subcode' => null,
                'name'    => 'Ukrainian',
                'region'  => null,
                'flag'    => 'UA',
            ],
            [
                'code'    => 'ro',
                'subcode' => null,
                'name'    => 'Romanian',
                'region'  => null,
                'flag'    => 'RO',
            ],
            [
                'code'    => 'la',
                'subcode' => null,
                'name'    => 'Latin',
                'region'  => null,
                'flag'    => 'VA',
            ],
            [
                'code'    => 'cs',
                'subcode' => null,
                'name'    => 'Czech',
                'region'  => null,
                'flag'    => 'CZ',
            ],
            [
                'code'    => 'ru',
                'subcode' => null,
                'name'    => 'Russian',
                'region'  => null,
                'flag'    => 'RU',
            ],
            [
                'code'    => 'ja',
                'subcode' => null,
                'name'    => 'Japanese',
                'region'  => null,
                'flag'    => 'JP',
            ],
            [
                'code'    => 'nl',
                'subcode' => null,
                'name'    => 'Dutch',
                'region'  => null,
                'flag'    => 'NL',
            ],
            [
                'code'    => 'de',
                'subcode' => null,
                'name'    => 'German',
                'region'  => null,
                'flag'    => 'DE',
            ],
            [
                'code'    => 'sv',
                'subcode' => null,
                'name'    => 'Swedish',
                'region'  => null,
                'flag'    => 'SE',
            ],
            [
                'code'    => 'ca',
                'subcode' => null,
                'name'    => 'Catalan',
                'region'  => null,
                'flag'    => null, // No flag in the sprite... TODO
            ],
            [
                'code'    => 'eo',
                'subcode' => null,
                'name'    => 'Esperanto',
                'region'  => null,
                'flag'    => null, // No flag in the sprite... TODO
            ],
            [
                'code'    => 'hu',
                'subcode' => null,
                'name'    => 'Hungarian',
                'region'  => null,
                'flag'    => 'HU',
            ],
            [
                'code'    => 'pl',
                'subcode' => null,
                'name'    => 'Polish',
                'region'  => null,
                'flag'    => 'PL',
            ],
        ], ['code', 'subcode'], ['name', 'region']);
    }

    public function seedCourses(): void
    {
        Language::pluck('id', 'code')->each(function ($fromLanguage) {
            Language::pluck('id', 'code')->each(function ($language) use ($fromLanguage) {
                if ($fromLanguage !== $language) {
                    Course::create([
                        'from_language' => $fromLanguage,
                        'language_id'   => $language,
                        'enabled'       => false,
                    ]);
                }
            });
        });

        collect([
            ['en', 'es'],
            ['en', 'fr'],
            ['en', 'pt'],
            ['en', 'it'],
            ['en', 'uk'],
            ['en', 'de'],
            ['es', 'en'],
            ['es', 'fr'],
            ['es', 'pt'],
            ['es', 'uk'],
            ['it', 'en'],
            ['fr', 'en'],
            ['pt', 'en'],
            ['uk', 'en'],
            ['uk', 'es'],
        ])->each(function ($toFrom) {
            [ $to, $from ] = $toFrom;

            Course::withoutGlobalScopes()
                ->whereHas('fromLanguage', fn ($q) => $q->where('code', $from))
                ->whereHas('language', fn ($q) => $q->where('code', $to))
                ->update(['enabled' => true]);
        });
    }

    private function seedLearnables(): void
    {
        $fromLanguage = Language::whereCode('uk')->firstOrFail();
        $toLanguage   = Language::whereCode('en')->firstOrFail();

        (new LearnableSeeder())->seed($fromLanguage, $toLanguage, 'uk-1');

        DB::connection()->getPdo()->exec(
            File::get(__DIR__ . '/dumps/learnables-seed-1.sql'),
        );
    }

    private function seedExerciseTypes()
    {
        ExerciseType::upsert([
            [
                'type'                     => 'ReadAndTranslate',
                'requires_listening'       => false,
                'requires_speaking'        => false,
                'requires_target_keyboard' => true,
                'spec'                     => json_encode([]), // TODO
                'description'              => 'Translate this sentence',
            ],
            [
                'type'                     => 'ReadAndTranslateBack',
                'requires_listening'       => false,
                'requires_speaking'        => false,
                'requires_target_keyboard' => false,
                'spec'                     => json_encode([]), // TODO
                'description'              => 'What does this mean?',
            ],
            [
                'type'                     => 'ReadAndPickTheWords',
                'requires_listening'       => false,
                'requires_speaking'        => false,
                'requires_target_keyboard' => false,
                'spec'                     => json_encode([]), // TODO
                'description'              => 'Translate this sentence',
            ],
            [
                'type'                     => 'ReadAndPickTheWordsBack',
                'requires_listening'       => false,
                'requires_speaking'        => false,
                'requires_target_keyboard' => false,
                'spec'                     => json_encode([]), // TODO
                'description'              => 'What does this mean?',
            ],
            [
                'type'                     => 'ReadAndSpeak',
                'requires_listening'       => false,
                'requires_speaking'        => true,
                'requires_target_keyboard' => false,
                'spec'                     => json_encode([]), // TODO
                'description'              => 'Repeat this',
            ],
            [
                'type'                     => 'ReadAndSpeakTranslation',
                'requires_listening'       => false,
                'requires_speaking'        => true,
                'requires_target_keyboard' => false,
                'spec'                     => json_encode([]), // TODO
                'description'              => 'Repeat this',
            ],
            [
                'type'                     => 'ListenAndWrite',
                'requires_listening'       => true,
                'requires_speaking'        => false,
                'requires_target_keyboard' => true,
                'spec'                     => json_encode([]), // TODO
                'description'              => 'What do you hear?',
            ],
            [
                'type'                     => 'ListenAndTranslate',
                'requires_listening'       => true,
                'requires_speaking'        => false,
                'requires_target_keyboard' => false,
                'spec'                     => json_encode([]), // TODO
                'description'              => 'Translate what you hear',
            ],
            [
                'type'                     => 'ListenAndPickTheWords',
                'requires_listening'       => true,
                'requires_speaking'        => false,
                'requires_target_keyboard' => false,
                'spec'                     => json_encode([]), // TODO
                'description'              => 'What do you hear?',
            ],
            [
                'type'                     => 'ListenAndPickTheWordsBack',
                'requires_listening'       => true,
                'requires_speaking'        => false,
                'requires_target_keyboard' => false,
                'spec'                     => json_encode([]), // TODO
                'description'              => 'What do you hear?',
            ],
            [
                'type'                     => 'ListenAndRepeat',
                'requires_listening'       => true,
                'requires_speaking'        => true,
                'requires_target_keyboard' => false,
                'spec'                     => json_encode([]), // TODO
                'description'              => 'Repeat what you hear',
            ],
            [
                'type'                     => 'SelectImageOption',
                'requires_listening'       => false,
                'requires_speaking'        => false,
                'requires_target_keyboard' => false,
                'spec'                     => json_encode([]), // TODO
                'description'              => 'What is the correct translation?',
            ],
            [
                'type'                     => 'TranslateWithImage',
                'requires_listening'       => false,
                'requires_speaking'        => false,
                'requires_target_keyboard' => false,
                'spec'                     => json_encode([]), // TODO
                'description'              => '',
            ],
            [
                'type'                     => 'TranslateWithImageBack',
                'requires_listening'       => false,
                'requires_speaking'        => false,
                'requires_target_keyboard' => true,
                'spec'                     => json_encode([]), // TODO
                'description'              => '',
            ],
        ], ['type'], ['requires_listening', 'requires_speaking', 'requires_target_keyboard', 'description', 'spec']);
    }
};
