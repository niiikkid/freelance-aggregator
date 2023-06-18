<?php

namespace App\Services\FreelanceCrawlerService\ValueObject;

use App\Enums\FreelanceEnum;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use JsonSerializable;

class FeedValue implements Arrayable, JsonSerializable
{
    public function __construct(
        public FreelanceEnum $freelance,
        public Collection $items,
    )
    {}

    public function toArray(): array
    {
        return [
            'freelance' => $this->freelance->value,
            'items' => $this->items->toArray(),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
