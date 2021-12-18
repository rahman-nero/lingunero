<?php

use App\Http\Controllers\Library\LibraryController;
use App\Http\Controllers\Library\Sentences\ManageController as SentenceManageController;
use App\Http\Controllers\Library\Sentences\PracticeController as SentencePracticeController;
use App\Http\Controllers\Library\Words\ManageController;
use App\Http\Controllers\Library\Words\PracticeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\User\UserController;
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
    // "Профиль"
    Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

    // Главная страница
    Route::get('/', [MainController::class, 'index'])
        ->name('home');

    // Просмотр библиотеки
    Route::get('/library/{libraryId}', [MainController::class, 'library'])
        ->name('library.show')
        ->whereNumber('libraryId');

    // Управление библиотекой
    Route::group(['as' => 'manage.library.'], function () {
        // Страница создания библиотеки
        Route::get('/library/create', [LibraryController::class, 'create'])
            ->name('create.show');

        // Ендпоинт создания библиотеки - ну т.е store-метод
        Route::post('/library/create', [LibraryController::class, 'store'])
            ->name('create.store');

        // Обновить библиотеку
        Route::post('/library/{libraryId}/edit', [LibraryController::class, 'update'])
            ->name('edit.store')
            ->whereNumber('libraryId');

        // Удалить библиотеку
        Route::delete('/library/{libraryId}', [LibraryController::class, 'delete'])
            ->name('delete')
            ->whereNumber('libraryId');
    });

    //////////// Слова

    // Карточки
    Route::get('/library/{libraryId}/cards', [PracticeController::class, 'cards'])
        ->name('library.words.studying')
        ->whereNumber('libraryId');

    ////////// Управление словами
    Route::group(['as' => 'manage.library.words.'], function () {

        // Страница редактирования слов
        Route::get('manage/library/{libraryId}/words/edit', [ManageController::class, 'edit'])
            ->whereNumber(['libraryId'])
            ->name('edit.show');

        // ендпоинт редактирования слов - отправка
        Route::post('manage/library/{libraryId}/words/edit', [ManageController::class, 'update'])
            ->whereNumber(['libraryId'])
            ->name('edit.store');

        // Удалени слова
        Route::delete('manage/library/{libraryId}/words/{wordId}', [ManageController::class, 'delete'])
            ->whereNumber(['libraryId', 'wordId'])
            ->name('edit.delete');


        // Страница добавлении слов
        Route::get('manage/library/{libraryId}/words/add', [ManageController::class, 'show'])
            ->whereNumber(['libraryId'])
            ->name('add.show');

        // Страница добавлении слов
        Route::post('manage/library/{libraryId}/words/add', [ManageController::class, 'store'])
            ->whereNumber(['libraryId'])
            ->name('add.store');
    });

    ////////// Практика слов
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


    ///////// Предложения
    Route::group(['as' => 'manage.library.sentences.'], function () {

        // Страница редактирования предложения
        Route::get('manage/library/{libraryId}/sentences/edit', [SentenceManageController::class, 'show'])
            ->whereNumber(['libraryId'])
            ->name('edit.show');

        // ендпоинт редактирования предложения - отправка
        Route::post('manage/library/{libraryId}/sentences/edit', [SentenceManageController::class, 'update'])
            ->whereNumber(['libraryId'])
            ->name('edit.store');

        // Удаление предложения
        Route::delete('manage/library/{libraryId}/sentences/{wordId}', [SentenceManageController::class, 'delete'])
            ->whereNumber(['libraryId', 'wordId'])
            ->name('edit.delete');


        // Страница добавлении предложении
        Route::get('manage/library/{libraryId}/sentences/add', [SentenceManageController::class, 'create'])
            ->whereNumber(['libraryId'])
            ->name('add.show');

        // Страница добавлении предложения - Пост
        Route::post('manage/library/{libraryId}/sentences/add', [SentenceManageController::class, 'store'])
            ->whereNumber(['libraryId'])
            ->name('add.store');

    });


    // Страница для практики
    Route::get('/library/{libraryId}/sentences/practice', [SentencePracticeController::class, 'index'])
        ->name('library.sentences.practice.index')
        ->whereNumber(['libraryId']);

    // Проверка предложении и высчет статистики
    Route::post('/library/{libraryId}/sentences/practice', [SentencePracticeController::class, 'store'])
        ->name('library.sentences.practice.store')
        ->whereNumber(['libraryId']);

    Route::get('/library/{libraryId}/sentences/statistic/{statisticId}', [SentencePracticeController::class, 'statistic'])
        ->name('library.sentences.practice.statistic')
        ->whereNumber(['libraryId', 'statisticId']);


});

// TODO: Завершить вывод сообщении, нормально
