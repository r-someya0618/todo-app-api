<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// health check
Route::get('/hc', function () {
    return 'healthy';
});

// ログイン処理
Route::post('login', [LoginController::class, 'login']);


// 認証が必要なルーティング
Route::middleware('auth:sanctum')->group(function () {
    // ログアウト処理
    Route::middleware('auth:sanctum')->post('logout', [LoginController::class, 'logout']);

    // /user ルート: 認証されたユーザーの情報を返す
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // /todos ルート: Todoリソースの操作
    Route::prefix('todos')->controller(TodoController::class)->group(function () {
        Route::get('/', 'index'); // Todoの一覧取得
        Route::post('/', 'store'); // Todoの新規作成
    });
});