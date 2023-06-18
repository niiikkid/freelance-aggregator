<?php

namespace App\Observers;

use App\Contracts\WorkLineServiceContract;
use App\Models\Order;

class OrderObserver
{
    public $afterCommit = true;

    public function created(Order $order): void
    {
        make(WorkLineServiceContract::class)->process($order);
    }
}
