<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::any('test', function () {
    dd(\App\Models\WordFilter::first()->telegramUser);
});

Route::any('telegram-bot/webhook', function () {
    make(\App\Contracts\TelegramBotServiceContract::class)
        ->handleWebhook();
});

