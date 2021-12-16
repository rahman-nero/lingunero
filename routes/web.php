<?php

use App\Http\Controllers\Library\LibraryController;
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


    Route::get('/', [MainController::class, 'index'])
        ->name('home');

    Route::get('/library/{libraryId}', [MainController::class, 'library'])
        ->name('library.show')
        ->whereNumber('libraryId');

    // Библиотека
    Route::group(['as' => 'manage.library.'], function () {
        // Страница создания библиотеки
        Route::get('/library/create', [LibraryController::class, 'create'])
            ->name('create.show');

        // Ендпоинт создания библиотеки - ну т.е store-метод
        Route::post('/library/create', [LibraryController::class, 'createStore'])
            ->name('create.store');

        // Обновить библиотеку
        Route::post('/library/{libraryId}/edit', [LibraryController::class, 'editStore'])
            ->name('edit.store')
            ->whereNumber('libraryId');

        // Удалить библиотеку
        Route::delete('/library/{libraryId}', [LibraryController::class, 'delete'])
            ->name('delete')
            ->whereNumber('libraryId');
    });


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

    // Просмотр статистики слов
    Route::get('/library/{libraryId}/words/statistic/{statisticId}', [PracticeController::class, 'statistic'])
        ->name('library.words.statistic.show')
        ->whereNumber(['libraryId', 'statisticId']);


    ///////////////// Управление словами
    Route::group(['as' => 'manage.'], function () {

        // Страница редактирования слов
        Route::get('manage/library/{libraryId}/words/edit', [ManageController::class, 'edit'])
            ->whereNumber(['libraryId'])
            ->name('library.words.edit.show');

        // ендпоинт редактирования слов - отправка
        Route::post('manage/library/{libraryId}/words/edit', [ManageController::class, 'editStore'])
            ->whereNumber(['libraryId'])
            ->name('library.words.edit.store');

        // Удалени слова
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


