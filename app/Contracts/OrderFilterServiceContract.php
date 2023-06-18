<?php

namespace App\Contracts;

use App\Models\Order;
use App\Models\TelegramUser;

interface OrderFilterServiceContract
{
    public function isAllowed(Order $order, TelegramUser $telegramUser): bool;
}
