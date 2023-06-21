<?php

namespace App\Telegram\Commands;

use App\Models\TelegramUser;
use App\Models\WordFilter;
use Telegram\Bot\Commands\Command;

class ShowFilterWordListCommand extends Command
{
    protected string $name = 'show_filter_word_list';
    protected string $description = 'Показывает список ваших фильтр-слов.';

    public function handle()
    {
        /**
         * @var TelegramUser $telegramUser
         */
        $telegramUser = TelegramUser::where([
            'telegram_id' => $this->getUpdate()->getChat()->getId()
        ])->first();

        $words = $telegramUser->wordFilters()
            ->get()
            ->transform(function (WordFilter $wordFilter) {
                $wordFilter->type_original = $wordFilter->type->value;

                return $wordFilter;
            })
            ->groupBy('type_original');

        $text = "*Ваши фильтр-слова:*\r\n";

        $words->each(function ($item, $key) use (&$text) {
            $text .= "*Тип: {$key}*\r\n";
            $item->each(function (WordFilter $wordFilter) use (&$text) {
                $text .= "$wordFilter->id: $wordFilter->word\r\n";
            });
        });

        $this->replyWithMessage([
            'text' => $text,
            'parse_mode' => 'markdown'
        ]);
    }
}
