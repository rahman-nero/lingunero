<?php

use App\Http\Controllers\Library\Words\ManageController;
use App\Http\Controllers\Library\Words\PracticeController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';


Route::group(['middleware' => 'auth'], function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    Route::get('/', [MainController::class, 'index'])->name('home');

    // Библиотека
    Route::get('/library/{libraryId}', [MainController::class, 'library'])
        ->name('library.show')
        ->whereNumber('libraryId');

    // Карточки
    Route::get('/library/{libraryId}/cards', [PracticeController::class, 'cards'])
        ->name('library.words.studying')
        ->whereNumber('libraryId');

    // Практика слов
    Route::get('/library/{libraryId}/words/practice', [PracticeController::class, 'practice'])
        ->name('library.words.practice.index')
        ->whereNumber('libraryId');

    // Практика слов - проверка слов и создание статистики
    Route::post('/library/{libraryId}/words/practice', [PracticeController::class, 'store'])
        ->name('library.words.practice.store')
        ->whereNumber('libraryId');

    // Просмотр статистики
    Route::get('/library/{libraryId}/words/statistic/{statisticId}', [PracticeController::class, 'statistic'])
        ->name('library.words.statistic.show')
        ->whereNumber(['libraryId', 'statisticId']);

    ///////////////// Управление словами
    Route::group(['as' => 'manage.'], function () {

        // Страница редактирования слов
        Route::get('manage/library/{libraryId}/words/edit', [ManageController::class, 'edit'])
            ->whereNumber(['libraryId'])
            ->name('library.words.edit.show');

        Route::delete('manage/library/{libraryId}/words/{wordId}', [ManageController::class, 'deleteWord'])
            ->whereNumber(['libraryId', 'wordId'])
            ->name('library.words.edit.delete');


        // Страница добавлении слов
        Route::get('manage/library/{libraryId}/words/add', [ManageController::class, 'add'])
            ->whereNumber(['libraryId'])
            ->name('library.words.add.show');

        // Страница добавлении слов
        Route::post('manage/library/{libraryId}/words/add', [ManageController::class, 'addStore'])
            ->whereNumber(['libraryId'])
            ->name('library.words.add.store');
    });
});


