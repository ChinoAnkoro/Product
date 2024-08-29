<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// 未認証ユーザーにログイン画面を表示
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('products.index'); // 商品一覧ページへのリダイレクト
    }
    return view('auth.login'); // ログイン画面のビューを指定
})->name('home');

// 認証ユーザー向けのルート
Route::middleware(['auth'])->group(function () {
    Route::resource('products', ProductController::class);
    
    // プロフィール関連のルート
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';
