<?php

namespace App\Services\OrderService;

use App\Contracts\OrderServiceContract;
use App\Models\Order;
use App\Services\OrderService\DTO\CreateOrderDTO;

class OrderService implements OrderServiceContract
{
    public function create(CreateOrderDTO $dto): Order
    {
        return Order::create([
            'freelance' => $dto->freelance,
            'title' => $dto->title,
            'link' => $dto->link,
            'description' => $dto->description,
            'category' => $dto->category,
            'published_at' => $dto->published_at,
        ]);
    }
}
