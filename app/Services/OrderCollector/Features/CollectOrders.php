<?php

namespace App\Services\OrderCollector\Features;

use App\Services\FreelanceCrawlerService\Crawlers\ArtisterCrawler;
use App\Services\FreelanceCrawlerService\Crawlers\BaseCrawler;
use App\Services\FreelanceCrawlerService\Crawlers\FLCrawler;
use App\Services\FreelanceCrawlerService\Crawlers\FreelanceCrawler;
use App\Services\FreelanceCrawlerService\Crawlers\KworkCrawler;
use App\Services\OrderCollector\Jobs\CollectOrdersJob;

class CollectOrders //TODO если я захочу сделать много пользователей и каждому свои настройки, то тут надо менять, страницы которые парсим
{
    public function collect(): void
    {
        $this->dispatchCrawler(new ArtisterCrawler('https://artister.ru/task/'));
        $this->dispatchCrawler(new FLCrawler('https://www.fl.ru/rss/all.xml?category=3'));
        $this->dispatchCrawler(new FreelanceCrawler('https://freelance.ru/rss/feed/list/s.590.40'));

        $pages = [
            ['c' => 24, 'attr' => 398966,],
            ['c' => 25, 'attr' => 401928],
            ['c' => 28, 'attr' => 819],
            ['c' => 28, 'attr' => 391843],
            ['c' => 28, 'attr' => 1273394],
            ['c' => 286, 'attr' => 1433356],
        ];

        foreach ($pages as $page) {
            $this->dispatchCrawler(new KworkCrawler($page));
        }
    }
    protected function dispatchCrawler(BaseCrawler $crawler): void
    {
        dispatch(
            new CollectOrdersJob($crawler)
        );
    }
}
