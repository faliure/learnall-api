<?php

use App\Http\Controllers\Auth\TokenController;
use App\Http\Controllers\Crud\CategoryController as CrudCategoryController;
use App\Http\Controllers\Crud\ExerciseController as CrudExerciseController;
use App\Http\Controllers\Crud\LanguageController as CrudLanguageController;
use App\Http\Controllers\Crud\LessonController as CrudLessonController;
use App\Http\Controllers\Crud\SentenceController as CrudSentenceController;
use App\Http\Controllers\Crud\UnitController as CrudUnitController;
use App\Http\Controllers\Crud\UserController as CrudUserController;
use App\Http\Controllers\Crud\WordController as CrudWordController;
use App\Http\Controllers\LanguageController;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', fn () => "LearnAll API v1");

Route::get('ping', fn () => "Pong!");

Route::post('/auth/sanctum', TokenController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', fn () => new UserResource(me()));
});

/**
 * CRUD Actions
 */
Route::apiResources([
    '/exercises'  => CrudExerciseController::class,
    '/languages'  => CrudLanguageController::class,
    '/lessons'    => CrudLessonController::class,
    '/sentences'  => CrudSentenceController::class,
    '/units'      => CrudUnitController::class,
    '/users'      => CrudUserController::class,
    '/words'      => CrudWordController::class,
    '/categories' => CrudCategoryController::class,
]);

Route::get('languages/{language}/word', [LanguageController::class, 'word']);
