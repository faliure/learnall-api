<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Crud\CategoryController as CrudCategoryController;
use App\Http\Controllers\Crud\CourseController as CrudCourseController;
use App\Http\Controllers\Crud\ExerciseController as CrudExerciseController;
use App\Http\Controllers\Crud\ExerciseTypeController as CrudExerciseTypeController;
use App\Http\Controllers\Crud\LanguageController as CrudLanguageController;
use App\Http\Controllers\Crud\LearnableController as CrudLearnableController;
use App\Http\Controllers\Crud\LessonController as CrudLessonController;
use App\Http\Controllers\Crud\TranslationController as CrudTranslationController;
use App\Http\Controllers\Crud\UnitController as CrudUnitController;
use App\Http\Controllers\Crud\UserController as CrudUserController;
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
Route::get('/ping', fn () => "Pong!");

Route::controller(AuthController::class)->group(function () {
    Route::get('/auth', 'show');
    Route::post('/auth', 'store')->withoutMiddleware('auth:sanctum');
    Route::put('/auth', 'update');
    Route::delete('/auth', 'destroy');
})->middleware('auth:sanctum');

Route::get('learnables/*', [LearnableController::class, 'random']);

/**
 * CRUD Actions
 */
Route::apiResources([
    '/categories'     => CrudCategoryController::class,
    '/courses'        => CrudCourseController::class,
    '/exercises'      => CrudExerciseController::class,
    '/exercise-types' => CrudExerciseTypeController::class,
    '/languages'      => CrudLanguageController::class,
    '/learnables'     => CrudLearnableController::class,
    '/lessons'        => CrudLessonController::class,
    '/translations'   => CrudTranslationController::class,
    '/units'          => CrudUnitController::class,
    '/users'          => CrudUserController::class,
]);
