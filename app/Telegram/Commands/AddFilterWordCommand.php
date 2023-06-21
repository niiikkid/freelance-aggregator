<?php

namespace App\Telegram\Commands;

use App\Enums\WordFilterTypeEnum;
use App\Models\TelegramUser;
use App\Models\WordFilter;
use Telegram\Bot\Commands\Command;

class AddFilterWordCommand extends Command
{
    protected string $name = 'add_filter_word';
    protected string $pattern = '{type}{stop_word: .+}';
    protected string $description = 'Добавляет новое фильтр-слово.';

    public function handle()
    {
        $telegramUser = TelegramUser::where([
            'telegram_id' => $this->getUpdate()->getChat()->getId()
        ])->first();

        $type = WordFilterTypeEnum::tryFrom(strtolower(trim($this->argument('type'))));

        if (empty($type)) {
            $this->replyWithMessage([
                'text' => 'Такого типа фильтр-слова не существует - ' . $this->argument('type'),
            ]);
            return;
        }

        $stop_word = strtolower(trim($this->argument('stop_word')));

        if (empty($stop_word)) {
            $this->replyWithMessage([
                'text' => 'Необходимо ввести фильтр-слово.',
            ]);
            return;
        }

        $wordFilter = WordFilter::create([
            'word' => $stop_word,
            'type' => $type->value,
            'telegram_user_id' => $telegramUser->id,
        ]);

        $this->replyWithMessage([
            'text' => "Фильтр-слово: $wordFilter->word типа: $type->value сохранено."
        ]);
    }
}
