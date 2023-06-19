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
        $pages = [
            [
                'c' => 24,
                'attr' => 398966,
            ],
            [
                'c' => 25,
                'attr' => 401928
            ],
            [
                'c' => 28,
                'attr' => 819
            ],
            [
                'c' => 28,
                'attr' => 391843
            ],
            [
                'c' => 28,
                'attr' => 1273394
            ],
            [
                'c' => 286,
                'attr' => 1433356
            ],
        ];

        Bus::chain([
            new CollectOrdersJob(new FLCrawler('https://www.fl.ru/rss/all.xml?category=3')), //TODO
            new CollectOrdersJob(new FreelanceCrawler('https://freelance.ru/rss/feed/list/s.590.40')),
            new CollectOrdersJob(new KworkCrawler()),
        ])
            ->onQueue('orders-collector')
            ->dispatch();
    }
}
