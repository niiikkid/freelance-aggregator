<?php

namespace App\Services\OrderFilterService;

use App\Contracts\OrderFilterServiceContract;
use App\Enums\WordFilterTypeEnum;
use App\Models\Order;
use App\Models\TelegramUser;
use App\Models\WordFilter;
use Illuminate\Support\Collection;

class OrderFilterService implements OrderFilterServiceContract
{
    public function isAllowed(Order $order, TelegramUser $telegramUser): bool
    {
        /**
         * @var Collection<int, WordFilter> $filters
         */
        $filters = $telegramUser->wordFilters()
            ->where('type', WordFilterTypeEnum::STOP_WORD)
            ->get();

        $result = true;

        foreach ($filters as $filter) {
            if (preg_match("/".$filter->word."/miu", strtolower($order->title))) {
                return false;
            }

            if (preg_match("/".$filter->word."/miu", strtolower($order->description))) {
                return false;
            }
        }

        return $result;
    }
}
