<?php

namespace App\Services\TelegramBotService;

use App\Contracts\TelegramBotServiceContract;
use App\Services\TelegramBotService\CallbackEvent\CallbackEvent;
use Telegram\Bot\Api;

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
                    make(CallbackEvent::class)->handle($update);
                }
            }
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
