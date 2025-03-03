<?php

use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// health check
Route::get('/hc', function () {
    return 'healthy';
});

// 認証が必要なルーティング
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('todos')->controller(TodoController::class)->group(function () {
    Route::get('/', 'index'); // Todoの一覧取得
    Route::post('/', 'store'); // Todoの新規作成
});