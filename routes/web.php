<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;

// お問い合わせ入力画面表示
Route::get('/', [ContactController::class, 'index'])->name('contact.index');

// お問い合わせフォーム送信（バリデーション実行・確認画面等へ）
Route::post('/contacts/confirm', [ContactController::class, 'confirm'])->name('contact.confirm');