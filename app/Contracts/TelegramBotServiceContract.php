<?php

namespace App\Contracts;

interface TelegramBotServiceContract
{
    public function handleWebhook(): void;
}
