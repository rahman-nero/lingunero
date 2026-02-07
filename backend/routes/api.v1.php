<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\Grammary\GrammaryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API V1 Routes
|--------------------------------------------------------------------------
|
| Маршруты API версии 1 для аутентификации через Laravel Sanctum.
| Все маршруты автоматически префиксируются как /api/v1
|
*/

// Публичные маршруты (без аутентификации)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Защищенные маршруты (требуют токен аутентификации)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/grammary', [GrammaryController::class, 'index']);
    Route::get('/grammary/{id}/practices', [GrammaryController::class, 'practices']);
    Route::post('/grammary/{id}/practices', [GrammaryController::class, 'submitPractice']);
    Route::get('/grammary/{id}', [GrammaryController::class, 'show']);
});