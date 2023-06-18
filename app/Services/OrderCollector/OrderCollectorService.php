<?php

namespace App\Services\OrderCollector;

use App\Contracts\OrderCollectorServiceContract;
use App\Services\OrderCollector\Features\CollectOrders;

class OrderCollectorService implements OrderCollectorServiceContract
{
    public function collect(): void
    {
        make(CollectOrders::class)->collect();
    }
}
