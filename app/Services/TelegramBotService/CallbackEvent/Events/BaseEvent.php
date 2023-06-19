<?php

namespace App\Services\TelegramBotService\CallbackEvent\Events;

use Telegram\Bot\Objects\Update;

abstract class BaseEvent
{
    abstract public static function makeFromCallbackData(array $callback_data): ?self;

    abstract public function getCallbackData(): string;

    abstract public function handle(Update $update): void;
}
