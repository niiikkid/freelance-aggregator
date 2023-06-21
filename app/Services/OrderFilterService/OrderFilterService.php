<?php

namespace App\Services\OrderFilterService;

use App\Contracts\OrderFilterServiceContract;
use App\Enums\FreelanceEnum;
use App\Enums\WordFilterTypeEnum;
use App\Models\Order;
use App\Models\TelegramUser;
use App\Models\WordFilter;
use Illuminate\Support\Collection;

class OrderFilterService implements OrderFilterServiceContract
{
    public function isAllowed(Order $order, TelegramUser $telegramUser): bool
    {
        if ($order->freelance->equals(FreelanceEnum::ARTISTER)) { //TODO создать функционал для этого
            return true;
        }

        /**
         * @var Collection<int, WordFilter> $stop_filters
         */
        $stop_filters = $telegramUser->wordFilters()
            ->where('type', WordFilterTypeEnum::STOP)
            ->get();

        /**
         * @var Collection<int, WordFilter> $cancel_filters
         */
        $cancel_filters = $telegramUser->wordFilters()
            ->where('type', WordFilterTypeEnum::CANCEL)
            ->get();

        $result = true;

        foreach ($stop_filters as $stop_filter) {
            $invalid_title = false;
            $invalid_description = false;

            if (preg_match("/".$stop_filter->word."/miu", strtolower($order->title))) {
                $invalid_title = true;
            }

            if (preg_match("/".$stop_filter->word."/miu", strtolower($order->description))) {
                $invalid_description = true;
            }

            $invalid = $invalid_title || $invalid_description;
            if ($invalid) {
                $valid = false;

                foreach ($cancel_filters as $cancel_filter) {
                    $valid_title = false;
                    $valid_description = false;

                    if (preg_match("/".$cancel_filter->word."/miu", strtolower($order->title))) {
                        $valid_title = true;
                    }

                    if (preg_match("/".$cancel_filter->word."/miu", strtolower($order->description))) {
                        $valid_description = true;
                    }

                    $valid = $valid_title || $valid_description;

                    if ($valid) {
                        break;
                    }
                }

                if (! $valid) {
                    return false;
                }
            }
        }

        return $result;
    }
}
