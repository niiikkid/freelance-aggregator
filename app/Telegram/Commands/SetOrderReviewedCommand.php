<?php

namespace App\Telegram\Commands;

use Telegram\Bot\Commands\Command;

class SetOrderReviewedCommand extends Command
{
    protected string $name = 'set_order_reviewed';
    protected string $pattern = '{order}';
    protected string $description = 'Заказ обработан.';

    public function handle()
    {
        /*$telegramUser = TelegramUser::where([
            'telegram_id' => $this->getUpdate()->getChat()->getId()
        ])->first();

        $stop_word = $this->argument('stop_word');
        $stop_word = trim($stop_word);

        $wordFilter = WordFilter::create([
            'word' => $stop_word,
            'type' => WordFilterTypeEnum::STOP_WORD,
            'telegram_user_id' => $telegramUser->id,
        ]);*/

        $this->replyWithMessage([
            'text' => "Успех"
        ]);
    }
}
