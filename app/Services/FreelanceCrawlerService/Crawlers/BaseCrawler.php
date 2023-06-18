<?php

namespace App\Services\FreelanceCrawlerService\Crawlers;

use App\Enums\FreelanceEnum;
use App\Services\FreelanceCrawlerService\ValueObject\FeedItemValue;
use Illuminate\Support\Collection;

abstract class BaseCrawler
{
    abstract public function getSourceName(): FreelanceEnum;

    /**
     * @return Collection<int, FeedItemValue>
     */
    abstract public function crawl(): Collection;
}
