<?php

namespace App\Services\FreelanceCrawlerService\ValueObject;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

class FeedItemValue implements Arrayable, JsonSerializable
{
    public function __construct(
        public string $title,
        public string $link,
        public string $description,
        public string $category,
        public Carbon $published_at,
    )
    {}

    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'link' => $this->link,
            'description' => $this->description,
            'category' => $this->category,
            'published_at' => $this->published_at->toDateTimeString(),
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
