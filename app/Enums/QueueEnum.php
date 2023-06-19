<?php

namespace App\Enums;

use App\Traits\Enum\Compare;
use App\Traits\Enum\Values;

enum QueueEnum: string
{
    use Values, Compare;

    case ORDERS_COLLECTOR = 'orders-collector';
    case WORK_LINE = 'work-line';
}
