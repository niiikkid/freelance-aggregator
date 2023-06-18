<?php

namespace App\Services\OrderCollector\Features;

use App\Services\FreelanceCrawlerService\Crawlers\FLCrawler;
use App\Services\FreelanceCrawlerService\Crawlers\FreelanceCrawler;
use App\Services\FreelanceCrawlerService\Crawlers\KworkCrawler;
use App\Services\OrderCollector\Jobs\CollectOrdersJob;
use Illuminate\Support\Facades\Bus;

class CollectOrders
{
    public function collect(): void
    {
        Bus::chain([
            new CollectOrdersJob(new FLCrawler()),
            new CollectOrdersJob(new FreelanceCrawler()),
            new CollectOrdersJob(new KworkCrawler()),
        ])
            ->onQueue('orders-collector')
            ->dispatch();
    }
}
