<?php

namespace App\Telegram\Commands;

use App\Enums\WordFilterTypeEnum;
use App\Models\TelegramUser;
use App\Models\WordFilter;
use Telegram\Bot\Commands\Command;

class DeleteStopWordCommand extends Command
{
    protected string $name = 'delete_stop_word';
    protected string $pattern = '{id}';
    protected string $description = 'Удаляет стоп слово.';

    public function handle()
    {
        $telegramUser = TelegramUser::where([
            'telegram_id' => $this->getUpdate()->getChat()->getId()
        ])->first();

        $stop_word_id = $this->argument('id');
        $stop_word_id = trim($stop_word_id);

        $wordFilter = $telegramUser->wordFilters()
            ->where('id', $stop_word_id)
            ->where('type', WordFilterTypeEnum::STOP_WORD)
            ->first();

        if ($wordFilter) {
            $this->replyWithMessage([
                'text' => "Стоп слово $wordFilter->word удалено."
            ]);

            $wordFilter->delete();
        } else {
            $this->replyWithMessage([
                'text' => "Стоп слово c id - $stop_word_id не существует."
            ]);
        }
    }
}
