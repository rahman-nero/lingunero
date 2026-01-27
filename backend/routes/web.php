<?php

use App\Http\Controllers\Library\LibraryController;
use App\Http\Controllers\Library\Sentences\ManageController as SentenceManageController;
use App\Http\Controllers\Library\Sentences\PracticeController as SentencePracticeController;
use App\Http\Controllers\Library\Words\ManageController;
use App\Http\Controllers\Library\Words\PracticeController;
use App\Http\Controllers\LLMChat\LLMChatMessageController;
use App\Http\Controllers\LLMChat\LLMChatRoomController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\User\FavoriteWordsController;
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

        Route::delete('/library/{libraryId}/words', [LibraryController::class, 'removeWordsOfLibrary'])
            ->name('words.clear')
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

        // Удаление слова
        Route::delete('manage/library/{libraryId}/words/{wordId}', [ManageController::class, 'delete'])
            ->whereNumber(['libraryId', 'wordId'])
            ->name('edit.delete');


        // Страница добавления слов
        Route::get('manage/library/{libraryId}/words/add', [ManageController::class, 'show'])
            ->whereNumber(['libraryId'])
            ->name('add.show');

        // Страница добавления слов
        Route::post('manage/library/{libraryId}/words/add', [ManageController::class, 'store'])
            ->whereNumber(['libraryId'])
            ->name('add.store');


        // Страница импорта слов
        Route::get('manage/library/{libraryId}/words/import', [ManageController::class, 'import'])
            ->whereNumber(['libraryId'])
            ->name('import');


        // Страница импорт слов - отправка
        Route::post('manage/library/{libraryId}/words/import', [ManageController::class, 'importStore'])
            ->whereNumber(['libraryId'])
            ->name('import.store');
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
        Route::get('manage/library/{libraryId}/sentences/edit', [SentenceManageController::class, 'edit'])
            ->whereNumber(['libraryId'])
            ->name('edit.show');

        // ендпоинт редактирования предложения - отправка
        Route::post('manage/library/{libraryId}/sentences/edit', [SentenceManageController::class, 'update'])
            ->whereNumber(['libraryId'])
            ->name('edit.store');

        // Удаление предложения
        Route::delete('manage/library/{libraryId}/sentences/{sentenceId}', [SentenceManageController::class, 'delete'])
            ->whereNumber(['libraryId', 'sentenceId'])
            ->name('edit.delete');


        // Страница добавлении предложении
        Route::get('manage/library/{libraryId}/sentences/add', [SentenceManageController::class, 'create'])
            ->whereNumber(['libraryId'])
            ->name('add.show');

        // Страница добавлении предложения - Пост
        Route::post('manage/library/{libraryId}/sentences/add', [SentenceManageController::class, 'store'])
            ->whereNumber(['libraryId'])
            ->name('add.store');


        // Страница импорта слов
        Route::get('manage/library/{libraryId}/sentences/import', [SentenceManageController::class, 'import'])
            ->whereNumber(['libraryId'])
            ->name('import');


        // Страница импорт слов - отправка
        Route::post('manage/library/{libraryId}/sentences/import', [SentenceManageController::class, 'importStore'])
            ->whereNumber(['libraryId'])
            ->name('import.store');
    });


    // Страница для практики
    Route::get('/library/{libraryId}/sentences/practice', [SentencePracticeController::class, 'index'])
        ->name('library.sentences.practice.index')
        ->whereNumber(['libraryId']);

    // Страница просмотра предложений аккордионом
    Route::get('/library/{libraryId}/sentences/cards', [SentencePracticeController::class, 'cards'])
        ->name('library.sentences.practice.cards')
        ->whereNumber('libraryId');
    // Проверка предложении и высчет статистики
    Route::post('/library/{libraryId}/sentences/practice', [SentencePracticeController::class, 'store'])
        ->name('library.sentences.practice.store')
        ->whereNumber(['libraryId']);

    // Получившееся статистика
    Route::get('/library/{libraryId}/sentences/statistic/{statisticId}', [SentencePracticeController::class, 'statistic'])
        ->name('library.sentences.practice.statistic')
        ->whereNumber(['libraryId', 'statisticId']);


    ///////// Избранные

    // Показ всех избранных слов пользователя
    Route::get('/user/favorites', [FavoriteWordsController::class, 'index'])
        ->name('user.favorites');

    // Добавление слова в избранные
    Route::post('/user/favorites/{wordId}', [FavoriteWordsController::class, 'add'])
        ->name('user.favorites.add')
        ->whereNumber('wordId');

    // Удаление избранного слова
    Route::delete('/user/favorites/{id}', [FavoriteWordsController::class, 'delete'])
        ->name('user.favorites.delete')
        ->whereNumber('id');

    // Удаление избранного слова (запрос ajax) (Временное решение или нет)
    Route::delete('/user/favorites/{wordId}/ajax', [FavoriteWordsController::class, 'deleteAjax'])
        ->name('user.favorites.delete.ajax')
        ->whereNumber('wordId');


    ///////// Чат с LLM

    // Получить все чаты
    Route::get('/llm/chats', [LLMChatRoomController::class, 'index'])->name('llm.chats.index');

    // Создать новый чат
    Route::get('/llm/chats/create', [LLMChatRoomController::class, 'store'])->name('llm.chats.store');

    // Удалить чат
    Route::get('/llm/chats/{chat_id}/delete', [LLMChatRoomController::class, 'delete'])->name('llm.chats.delete');

    // Получить конкретный чат
    Route::get('/llm/chats/{chat_id}', [LLMChatRoomController::class, 'show'])->name('llm.chats.show');

    // Спросить у ИИ
    Route::post('/llm/{chat_id}/messages', [LLMChatMessageController::class, 'store']);
});
