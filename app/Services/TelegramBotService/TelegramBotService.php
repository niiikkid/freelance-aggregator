<?php

namespace App\Services\TelegramBotService;

use App\Contracts\TelegramBotServiceContract;
use Telegram\Bot\Api;
use Telegram\Bot\Helpers\Entities;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramBotService implements TelegramBotServiceContract
{
    public function __construct(
        protected Api $telegram
    )
    {}

    public function handleWebhook(): void
    {
        try {
            $update = $this->telegram->commandsHandler(true);

            if ($update->callbackQuery) {
                $this->telegram->answerCallbackQuery([
                    'callback_query_id' => $update->callbackQuery->getId(),
                ]);

                if ($update->callbackQuery->getData()) {
                    info();
                    $this->telegram->getCommandBus()->execute($update->callbackQuery->getData(), $update, []);
                }
            }
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
