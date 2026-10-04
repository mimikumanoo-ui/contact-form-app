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

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
});
