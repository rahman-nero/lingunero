<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix("v1")
    ->middleware('auth:sanctum')
    ->group(function () {

        Route::get('/hello', fn() => response()->json(['message' => 'hello']));

});
