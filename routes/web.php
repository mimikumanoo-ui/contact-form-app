<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// お問い合わせ入力画面
Route::get('/', [ContactController::class, 'index'])->name('contact.index');

// お問い合わせ確認画面
Route::post('/contacts/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');

// お問い合わせ送信処理
Route::post('/contacts', [ContactController::class, 'store'])->name('contact.store');

// お問い合わせ送信完了画面
Route::get('/thanks', [ContactController::class, 'thanks'])->name('contact.thanks');

// 管理画面（認証必須）
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::get('/contacts/{contact}', [AdminController::class, 'show'])->name('show');
    Route::delete('/contacts/{contact}', [AdminController::class, 'destroy'])->name('destroy');
});
