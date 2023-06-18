<?php

namespace App\Telegram\Commands;

use App\Enums\FilterWordTypeEnum;
use App\Models\TelegramUser;
use App\Models\WordFilter;
use Telegram\Bot\Commands\Command;

class ShowStopWordListCommand extends Command
{
    protected string $name = 'show_stop_word_list';
    protected string $description = 'Показывает список ваших стоп слов.';

    public function handle()
    {
        /**
         * @var TelegramUser $telegramUser
         */
        $telegramUser = TelegramUser::where([
            'telegram_id' => $this->getUpdate()->getMessage()->from->id
        ])->first();

        $stop_words = $telegramUser->wordFilters()
            ->where('type', FilterWordTypeEnum::STOP_WORD)
            ->get();

        $text = "Ваши стоп слова:\r\n";

        $stop_words->each(function (WordFilter $wordFilter) use (&$text) {
            $text .= "$wordFilter->id: $wordFilter->word\r\n";
        });

        $this->replyWithMessage([
            'text' => $text,
        ]);
    }
}
