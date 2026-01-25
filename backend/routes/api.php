<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')
    ->get('/user', function (Request $request) {
        return $request->user();
    });


Route::group(['middleware' => 'auth'], function () {

    // Очистить чат
    Route::delete('/llm/{chat_id}', []);

    // Получить историю чата
    Route::get('/llm/{chat_id}/messages', []);

    // Спросить у ИИ
    Route::post('/llm/{chat_id}/messages', []);
});
