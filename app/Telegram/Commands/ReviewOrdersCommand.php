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

        if (! $order) {
            return;
        }

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

        $freelance = ucfirst($order->freelance->value);
        $published_at = $order->published_at->toDateTimeString('minute');
        $title = $this->prepareText($order->title);
        $description = $this->prepareText($order->description);
info($title);
info($description);
        $this->replyWithMessage([
            'text' => "*$freelance:* $title\r\n\r\n$description\r\n\r\n*Опубликован:* $published_at\r\n\r\n*Всего заказов:* $orders_count",
            'reply_markup' => $keyboard,
            'parse_mode' => 'markdown'
        ]);
    }

    protected function prepareText(string $text): string
    {
        preg_match_all('~[a-z]+://\S+~miu', $text, $matches);

        foreach ($matches[0] as $match) {
            $text = str_replace($match, "[Ссылка]($match)", $text);
        }

        $text = str_replace('*', '\*', $text);
        $text = str_replace('_', ' ', $text);

        return $text;
    }
}
