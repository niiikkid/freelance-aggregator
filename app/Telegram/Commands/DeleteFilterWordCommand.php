<?php

namespace App\Telegram\Commands;

use App\Enums\WordFilterTypeEnum;
use App\Models\TelegramUser;
use App\Models\WordFilter;
use Telegram\Bot\Commands\Command;

class DeleteFilterWordCommand extends Command
{
    protected string $name = 'delete_filter_word';
    protected string $pattern = '{id}';
    protected string $description = 'Удаляет фильтр-слово.';

    public function handle()
    {
        $telegramUser = TelegramUser::where([
            'telegram_id' => $this->getUpdate()->getChat()->getId()
        ])->first();

        $word_id = trim($this->argument('id'));

        if (empty($word_id)) {
            $this->replyWithMessage([
                'text' => "Необходимо ввести id."
            ]);

            return;
        }

        $wordFilter = $telegramUser->wordFilters()
            ->where('id', $word_id)
            ->first();

        if ($wordFilter) {
            $this->replyWithMessage([
                'text' => "Фильтр-слово слово $wordFilter->word удалено."
            ]);

            $wordFilter->delete();
        } else {
            $this->replyWithMessage([
                'text' => "Фильтр-слово c id - $word_id не существует."
            ]);
        }
    }
}
