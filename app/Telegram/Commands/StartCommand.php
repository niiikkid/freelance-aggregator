<?php

namespace App\Telegram\Commands;

use App\Models\TelegramUser;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    protected string $name = 'start';
    protected string $description = 'Запускает бота, и вообще начало всех начал.';

    public function handle()
    {
        $telegramUser = TelegramUser::where([
            'telegram_id' => $this->getUpdate()->getMessage()->from->id
        ])->first();

        if (! $telegramUser) {
            $telegramUser = TelegramUser::create(
                [
                    'first_name' => $this->getUpdate()->getMessage()->from->first_name,
                    'username' => $this->getUpdate()->getMessage()->from->username,
                    'telegram_id' => $this->getUpdate()->getMessage()->from->id
                ]
            );

            $this->replyWithMessage([
                'text' => "Ну привет, {$telegramUser->first_name}.\r\n\r\nМы тебя так долго ждали и вот дождались... Теперь ты в хороших руках!\r\n\r\nЗаходи, располагайся. Сейчас чай пить будем. Расскажешь нам, как до такой жизни докатился, и где деньги спрятал(а)!",
            ]);
        }
    }
}
