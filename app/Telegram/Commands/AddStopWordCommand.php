<?php

namespace App\Telegram\Commands;

use App\Enums\FilterWordTypeEnum;
use App\Models\TelegramUser;
use App\Models\WordFilter;
use Telegram\Bot\Commands\Command;

class AddStopWordCommand extends Command
{
    protected string $name = 'add_stop_word';
    protected string $pattern = '{stop_word}';
    protected string $description = 'Добавляет новое стоп слово.';

    public function handle()
    {
        $telegramUser = TelegramUser::where([
            'telegram_id' => $this->getUpdate()->getMessage()->from->id
        ])->first();

        $stop_word = $this->argument('stop_word');
        $stop_word = trim($stop_word);

        $wordFilter = WordFilter::create([
            'word' => $stop_word,
            'type' => FilterWordTypeEnum::STOP_WORD,
            'telegram_user_id' => $telegramUser->id,
        ]);

        $this->replyWithMessage([
            'text' => "Стоп слово сохранено: $wordFilter->word"
        ]);
    }
}