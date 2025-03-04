<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // ログイン処理
    public function login(Request $request)
    {
        // バリデーション
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 認証処理
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // ログイン成功後、ユーザーを取得
            $user = Auth::user();

            // セッションベースの認証でSanctumのトークンを自動でセット
            return response()->json(['message' => 'Authenticated']);
        }

        // ログイン失敗
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // ログアウト処理
    public function logout(Request $request)
    {
        $request->user()->tokens->each(function ($token) {
            $token->delete();  // 発行された全てのトークンを削除
        });

        return response()->json(['message' => 'Logged out']);
    }
}
