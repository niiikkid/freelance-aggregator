<?php

namespace App\Observers;

use App\Contracts\WorkLineServiceContract;
use App\Enums\FilterWordTypeEnum;
use App\Models\WordFilter;

class WordFilterObserver
{
    public $afterCommit = true;

    public function created(WordFilter $wordFilter): void
    {
        $wordFilter->load('telegramUser');

        if ($wordFilter->type->equals(FilterWordTypeEnum::STOP_WORD)) {
            make(WorkLineServiceContract::class)->reprocessOrdersOfTelegramUser(
                $wordFilter->telegramUser
            );
        }
    }

    public function deleted(WordFilter $wordFilter): void
    {
        $wordFilter->load('telegramUser');

        if ($wordFilter->type->equals(FilterWordTypeEnum::STOP_WORD)) {
            make(WorkLineServiceContract::class)->reprocessOrdersOfTelegramUser(
                $wordFilter->telegramUser
            );
        }
    }
}
