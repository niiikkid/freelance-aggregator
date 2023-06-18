<?php

namespace App\Contracts;

use App\Models\Order;
use App\Services\OrderService\DTO\CreateOrderDTO;

interface OrderServiceContract
{
    public function create(CreateOrderDTO $dto): Order;
}
