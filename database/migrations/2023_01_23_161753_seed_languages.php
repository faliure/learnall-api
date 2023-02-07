<?php

use App\Models\Language;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Language::upsert([
            [
                'code'    => 'en',
                'subcode' => null,
                'name'    => 'English',
                'region'  => null,
            ],
            [
                'code'    => 'es',
                'subcode' => null,
                'name'    => 'Spanish',
                'region'  => 'Spain',
            ],
            [
                'code'    => 'fr',
                'subcode' => null,
                'name'    => 'French',
                'region'  => null,
            ],
            [
                'code'    => 'pt',
                'subcode' => 'br',
                'name'    => 'Portuguese',
                'region'  => 'Brazil',
            ],
            [
                'code'    => 'ua',
                'subcode' => null,
                'name'    => 'Ukrainian',
                'region'  => null,
            ],
            [
                'code'    => 'it',
                'subcode' => null,
                'name'    => 'Italian',
                'region'  => null,
            ],
        ], ['name', 'region'], ['code', 'subcode']);
    }
};
