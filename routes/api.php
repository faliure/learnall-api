<?php

use App\Http\Controllers\Auth\TokenController;
use App\Http\Controllers\Crud\CategoryController;
use App\Http\Controllers\Crud\ExerciseController;
use App\Http\Controllers\Crud\LanguageController;
use App\Http\Controllers\Crud\LessonController;
use App\Http\Controllers\Crud\SentenceController;
use App\Http\Controllers\Crud\UnitController;
use App\Http\Controllers\Crud\UserController;
use App\Http\Controllers\Crud\WordController;
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
    '/exercises'  => ExerciseController::class,
    '/languages'  => LanguageController::class,
    '/lessons'    => LessonController::class,
    '/sentences'  => SentenceController::class,
    '/units'      => UnitController::class,
    '/users'      => UserController::class,
    '/words'      => WordController::class,
    '/categories' => CategoryController::class,
]);
