<?php

namespace App\Telegram\Commands;

use App\Models\Order;
use App\Models\TelegramUser;
use App\Services\TelegramBotService\CallbackEvent\CallbackEvent;
use App\Services\TelegramBotService\CallbackEvent\Events\SetOrderReviewedEvent;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class ReviewOrdersCommand extends Command
{
    protected string $name = 'review_orders';
    protected string $description = 'Обработка заказов.';

    public function handle()
    {
        /**
         * @var TelegramUser $telegramUser
         */
        $telegramUser = TelegramUser::where([
            'telegram_id' => $this->getUpdate()->getChat()->getId()
        ])->first();

        /**
         * @var Order $order
         */
        $order = $telegramUser->orders()
            ->wherePivot('reviewed', 0)
            ->wherePivot('allowed', 1)
            ->orderByDesc('published_at')
            ->first();

        $orders_count = $telegramUser->orders()
            ->wherePivot('reviewed', 0)
            ->wherePivot('allowed', 1)
            ->count();


        $callback_data = make(CallbackEvent::class)->make(
            new SetOrderReviewedEvent($order)
        );

        $keyboard = Keyboard::make([
            'resize_keyboard' => true,
        ])
            ->inline()
            ->row([
                Keyboard::inlineButton(['text' => 'Закрыть', 'callback_data' => $callback_data]),
                Keyboard::inlineButton(['text' => 'Посмотреть', 'url' => $order->link])
            ]);

        $response = $this->replyWithMessage([
            'text' => "{$order->freelance->value}: $order->title\r\n\r\n$order->description\r\n\r\nВсего заказов: $orders_count",
            'reply_markup' => $keyboard
        ]);


        //info($response->getMessageId());
    }
}
