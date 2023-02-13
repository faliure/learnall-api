<?php

use App\Models\Course;
use App\Models\ExerciseType;
use App\Models\Language;
use Database\Migrations\Helpers\LearnableSeeder;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    private const LANGUAGE_CODE    = 'ua';
    private const TO_LANGUAGE_CODE = 'en';
    private const BATCH_NAME       = 'ua-1';

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
                'code'    => 'ua',
                'subcode' => null,
                'name'    => 'Ukrainian',
                'region'  => null,
                'flag'    => 'UA',
            ],
        ], ['code', 'subcode'], ['name', 'region']);
    }

    public function seedCourses(): void
    {
        $languages = Language::pluck('id', 'code');

        Course::insert([
            [
                'from_language' => $languages['en'],
                'language_id'   => $languages['es'],
                'enabled'       => true,
            ],
            [
                'from_language' => $languages['en'],
                'language_id'   => $languages['fr'],
                'enabled'       => true,
            ],
            [
                'from_language' => $languages['en'],
                'language_id'   => $languages['pt'],
                'enabled'       => false,
            ],
            [
                'from_language' => $languages['en'],
                'language_id'   => $languages['it'],
                'enabled'       => false,
            ],
            [
                'from_language' => $languages['en'],
                'language_id'   => $languages['ua'],
                'enabled'       => true,
            ],
            [
                'from_language' => $languages['es'],
                'language_id'   => $languages['en'],
                'enabled'       => true,
            ],
            [
                'from_language' => $languages['es'],
                'language_id'   => $languages['fr'],
                'enabled'       => true,
            ],
            [
                'from_language' => $languages['ua'],
                'language_id'   => $languages['en'],
                'enabled'       => true,
            ],
        ]);
    }

    private function seedLearnables(): void
    {
        $language   = Language::whereCode(self::LANGUAGE_CODE)->firstOrFail();
        $toLanguage = Language::whereCode(self::TO_LANGUAGE_CODE)->firstOrFail();

        (new LearnableSeeder())->seed($language, $toLanguage, self::BATCH_NAME);
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
