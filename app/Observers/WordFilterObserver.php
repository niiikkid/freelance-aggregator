<?php

namespace App\Observers;

use App\Contracts\WorkLineServiceContract;
use App\Models\WordFilter;

class WordFilterObserver
{
    public $afterCommit = true;

    public function created(WordFilter $wordFilter): void
    {
        $wordFilter->load('telegramUser');

        make(WorkLineServiceContract::class)->reprocessOrdersOfTelegramUser(
            $wordFilter->telegramUser
        );
    }

    public function deleted(WordFilter $wordFilter): void
    {
        $wordFilter->load('telegramUser');

        make(WorkLineServiceContract::class)->reprocessOrdersOfTelegramUser(
            $wordFilter->telegramUser
        );
    }
}
