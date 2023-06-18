<?php

namespace App\Services\FreelanceCrawlerService;

use App\Services\FreelanceCrawlerService\Crawlers\BaseCrawler;
use App\Services\FreelanceCrawlerService\ValueObject\FeedValue;

interface FreelanceCrawlerServiceContract
{
    public function crawl(BaseCrawler $crawler): FeedValue;
}
