<?php

namespace App\Services\TelegramBotService;

use App\Contracts\TelegramBotServiceContract;
use App\Models\TelegramUser;
use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramBotService implements TelegramBotServiceContract
{
    public function __construct(
        protected Api $telegram
    )
    {}

    public function handleWebhook(): void
    {
        info(123);
        $update = $this->telegram->commandsHandler(true);
        /*$text = $update->getMessage()->get('text');
        $chat = $update->getChat();

        if (strtolower(trim($text)) === '/start') {
            TelegramUser::firstOrCreate(
                [
                    'telegram_id' => $chat->getId()
                ],
                [
                    'first_name' => $chat->getFirstName(),
                    'username' => $chat->getUsername(),
                    'telegram_id' => $chat->getId()
                ]
            );
        }

        if (strtolower(trim($text)) === '/add_stop_word') {
            TelegramUser::firstOrCreate(
                [
                    'telegram_id' => $chat->getId()
                ],
                [
                    'first_name' => $chat->getFirstName(),
                    'username' => $chat->getUsername(),
                    'telegram_id' => $chat->getId()
                ]
            );
        }*/
    }
}
