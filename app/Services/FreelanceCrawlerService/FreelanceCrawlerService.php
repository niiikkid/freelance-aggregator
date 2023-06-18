<?php

namespace App\Services\FreelanceCrawlerService;

use App\Contracts\FreelanceCrawlerServiceContract;
use App\Services\FreelanceCrawlerService\Crawlers\BaseCrawler;
use App\Services\FreelanceCrawlerService\ValueObject\FeedValue;

class FreelanceCrawlerService implements FreelanceCrawlerServiceContract
{
    public function crawl(BaseCrawler $crawler): FeedValue
    {
        return new FeedValue(
            freelance: $crawler->getSourceName(),
            items: $crawler->crawl(),
        );
    }
}
