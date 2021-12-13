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
    Route::get('/library/{libraryId}/words', [PracticeController::class, 'index'])
        ->name('library.words.studying')
        ->whereNumber('libraryId');

});


