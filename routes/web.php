<?php

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

    // Практика слов - проверка
    Route::post('/library/{libraryId}/words/practice', [PracticeController::class, 'store'])
        ->name('library.words.practice.store')
        ->whereNumber('libraryId');


    // Просмотр статистики
    Route::get('/library/{libraryId}/words/statistic/{statisticId}', [PracticeController::class, 'statistic'])
        ->name('library.words.statistic.show')
        ->whereNumber(['libraryId', 'statisticId']);

});


