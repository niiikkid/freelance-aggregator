<?php

namespace App\Observers;

use App\Contracts\WorkLineServiceContract;
use App\Enums\WordFilterTypeEnum;
use App\Models\WordFilter;

class WordFilterObserver
{
    public $afterCommit = true;

    public function created(WordFilter $wordFilter): void
    {
        $wordFilter->load('telegramUser');

        if ($wordFilter->type->equals(WordFilterTypeEnum::STOP)) {
            make(WorkLineServiceContract::class)->reprocessOrdersOfTelegramUser(
                $wordFilter->telegramUser
            );
        }
    }

    public function deleted(WordFilter $wordFilter): void
    {
        $wordFilter->load('telegramUser');

        if ($wordFilter->type->equals(WordFilterTypeEnum::STOP)) {
            make(WorkLineServiceContract::class)->reprocessOrdersOfTelegramUser(
                $wordFilter->telegramUser
            );
        }
    }
}
