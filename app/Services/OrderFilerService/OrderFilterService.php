<?php

namespace App\Services\OrderFilerService;

use App\Contracts\OrderFilterServiceContract;
use App\Models\Order;
use App\Models\TelegramUser;

class OrderFilterService implements OrderFilterServiceContract
{
    public function isAllowed(Order $order, TelegramUser $telegramUser): bool
    {


        return false;
    }
}
