<?php

namespace App\Services\TelegramBotService\CallbackEvent;

use App\Services\TelegramBotService\CallbackEvent\Events\BaseEvent;
use App\Services\TelegramBotService\CallbackEvent\Events\SetOrderReviewedEvent;
use Telegram\Bot\Objects\Update;

class CallbackEvent
{
    public function make(BaseEvent $event): string
    {
        return $event->getCallbackData();
    }

    public function handle(Update $update): void
    {
        $event = $this->tryToDetectEvent($update->callbackQuery->getData());

        if ($event) {
            $event->handle($update);
        }
    }

    protected function tryToDetectEvent(string $callback_data): ?BaseEvent
    {
        $callback_data = json_decode($callback_data, true);

        if (! $callback_data['event']) {
            return null;
        }

        $available_events = [
            'set_order_reviewed' => SetOrderReviewedEvent::class,
        ];

        return $available_events[$callback_data['event']]::makeFromCallbackData($callback_data);
    }
}
