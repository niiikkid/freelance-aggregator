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
    /**
     * @var \App\Models\TelegramUser $telegramUser
     */
    $telegramUser = \App\Models\TelegramUser::first();

    $telegramUser->orders()->attach([
        1 => [
            'allowed' => null,
            'reviewed' => false,
        ],
    ]);
});

Route::any('telegram-bot/webhook', function () {
    make(\App\Contracts\TelegramBotServiceContract::class)
        ->handleWebhook();
});

