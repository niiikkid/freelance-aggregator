<?php

namespace App\Enums;

use App\Traits\Enum\Compare;
use App\Traits\Enum\Values;

enum WordFilterTypeEnum: string
{
    use Values, Compare;

    case STOP = 'stop';
    case CANCEL = 'cancel';
}
