<?php

namespace App\Services\WorkLineService;

use App\Contracts\WorkLineServiceContract;
use App\Models\Order;
use App\Models\TelegramUser;
use App\Services\WorkLineService\Jobs\ProcessOrderJob;
use App\Services\WorkLineService\Jobs\ReprocessOrdersOfTelegramUserJob;

class WorkLineService implements WorkLineServiceContract
{
    public function process(Order $order): void
    {
        dispatch(new ProcessOrderJob($order));
    }

    public function reprocessOrdersOfTelegramUser(TelegramUser $telegramUser): void
    {
        dispatch(new ReprocessOrdersOfTelegramUserJob($telegramUser));
    }
}
