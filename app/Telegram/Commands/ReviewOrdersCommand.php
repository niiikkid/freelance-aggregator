<?php

namespace App\Telegram\Commands;

use App\Enums\WordFilterTypeEnum;
use App\Models\Order;
use App\Models\TelegramUser;
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


        $keyboard = Keyboard::make([
            'inline_keyboard' => [
                [
                    ['text' => 'Закрыть', 'callback_data' => "set_order_reviewed $order->id"],
                    ['text' => 'Посмотреть', 'url' => $order->link]]
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ]);

        $this->replyWithMessage([
            'text' => "{$order->freelance->value}: $order->title\r\n\r\n$order->description\r\n\r\nВсего заказов: $orders_count",
            'reply_markup' => $keyboard
        ]);
    }
}
