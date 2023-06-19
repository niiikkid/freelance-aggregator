<?php

namespace App\Services\TelegramBotService\CallbackEvent\Events;

use App\Models\Order;
use App\Models\TelegramUser;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Update;

class SetOrderReviewedEvent extends BaseEvent
{
    public function __construct(
        protected Order $order,
    )
    {}

    public static function makeFromCallbackData(array $callback_data): ?BaseEvent
    {
        $order = Order::find($callback_data['data']);

        if (! $order) {
            return null;
        }

        return new self(
            Order::find($order)
        );
    }

    public function getCallbackData(): string
    {
        return json_encode([
            'event' => 'set_order_reviewed',
            'data' => $this->order->id
        ]);
    }

    public function handle(Update $update): void
    {
        Telegram::deleteMessage([
            'chat_id' => $update->getChat()->getId(),
            'message_id' => $update->getMessage()->getMessageId()
        ]);

        /**
         * @var TelegramUser $telegramUser
         */
        $telegramUser = TelegramUser::where([
            'telegram_id' => $update->getChat()->getId()
        ])->first();

        $this->order->telegramUsers()
            ->wherePivot('reviewed', 0)
            ->updateExistingPivot($telegramUser->id, [
                'reviewed' => true,
            ]);

        Telegram::triggerCommand('review_orders', $update);
    }
}
