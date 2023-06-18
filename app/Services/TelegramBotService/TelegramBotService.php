<?php

namespace App\Services\TelegramBotService;

use App\Contracts\TelegramBotServiceContract;
use Telegram\Bot\Api;

class TelegramBotService implements TelegramBotServiceContract
{
    public function __construct(
        protected Api $telegram
    )
    {}

    public function handleWebhook(): void
    {
        $this->telegram->commandsHandler(true);
    }
}
