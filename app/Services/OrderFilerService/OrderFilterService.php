<?php

namespace App\Services\OrderFilerService;

use App\Contracts\OrderFilterServiceContract;
use App\Models\Order;
use Illuminate\Support\Collection;

class OrderFilterService implements OrderFilterServiceContract
{
    /**
     * @param Collection<int, Order> $orders
     * @return Collection<int, Order>
     */
    public function filter(Collection $orders): Collection
    {
        

        return $orders;
    }
}
