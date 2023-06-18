<?php

namespace App\Services\OrderService\DTO;

use App\Contracts\DTOContract;
use App\Enums\FreelanceEnum;
use Carbon\Carbon;

class CreateOrderDTO extends DTOContract
{
    public function __construct(
        public string $external_id,
        public FreelanceEnum $freelance,
        public string $title,
        public string $link,
        public string $description,
        public string $category,
        public Carbon $published_at,
    )
    {}
}
