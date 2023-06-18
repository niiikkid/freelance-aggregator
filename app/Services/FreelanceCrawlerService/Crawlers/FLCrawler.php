<?php

namespace App\Services\FreelanceCrawlerService\Crawlers;

use App\Enums\FreelanceEnum;
use App\Services\FreelanceCrawlerService\ValueObject\FeedItemValue;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Vedmant\FeedReader\Facades\FeedReader;

class FLCrawler extends BaseCrawler
{
    public function getSourceName(): FreelanceEnum
    {
        return FreelanceEnum::FL;
    }

    /**
     * @return Collection<int, FeedItemValue>
     */
    public function crawl(): Collection
    {
        /**
         * @var \SimplePie\SimplePie $feed
         */
        $feed = FeedReader::read('https://www.fl.ru/rss/all.xml?category=3');

        $orders = collect();
        foreach ($feed->get_items() as $item) {
            $orders->push(new FeedItemValue(
                guid: $item->get_id(),
                title: $item->get_title(),
                link: $item->get_link(),
                description: $item->get_description(),
                category: $item->get_category(),
                published_at: Carbon::parse($item->get_date()),
            ));
        }

        return $orders;
    }
}
