<?php

namespace App\Enums;

use App\Traits\Enum\Compare;
use App\Traits\Enum\Values;

enum FreelanceEnum: string
{
    use Values, Compare;

    case FL = 'fl';
    case FREELANCE = 'freelance';
    case KWORK = 'kwork';
    case ARTISTER = 'artister';
}
