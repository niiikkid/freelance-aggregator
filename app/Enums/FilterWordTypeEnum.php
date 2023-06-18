<?php

namespace App\Enums;

use App\Traits\Enum\Compare;
use App\Traits\Enum\Values;

enum FilterWordTypeEnum: string
{
    use Values, Compare;

    case STOP_WORD = 'stop_word';
}
