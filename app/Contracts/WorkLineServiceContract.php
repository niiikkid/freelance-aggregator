<?php

namespace App\Contracts;

use App\Models\Order;
use App\Models\TelegramUser;

interface WorkLineServiceContract
{
    public function process(Order $order): void;

    public function reprocessOrdersOfTelegramUser(TelegramUser $telegramUser): void;
}
