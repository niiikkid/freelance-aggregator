<?php

namespace App\Contracts;

use App\Models\Order;
use Illuminate\Support\Collection;

interface OrderFilterServiceContract
{
    public function filter(Collection $orders): Collection;
}
