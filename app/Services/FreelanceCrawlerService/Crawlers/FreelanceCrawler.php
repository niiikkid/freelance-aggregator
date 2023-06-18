<?php

namespace App\Services\FreelanceCrawlerService\Crawlers;

use App\Enums\FreelanceEnum;
use App\Services\FreelanceCrawlerService\ValueObject\FeedItemValue;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Vedmant\FeedReader\Facades\FeedReader;

class FreelanceCrawler extends BaseCrawler
{
    public function getSourceName(): FreelanceEnum
    {
        return FreelanceEnum::FREELANCE;
    }

    /**
     * @return Collection<int, FeedItemValue>
     */
    public function crawl(): Collection
    {
        /**
         * @var \SimplePie\SimplePie $feed
         */
        $feed = FeedReader::read('https://freelance.ru/rss/feed/list/s.590.40');

        $orders = collect();
        foreach ($feed->get_items() as $item) {
            $orders->push(new FeedItemValue(
                title: $item->get_title(),
                link: $item->get_link(),
                description: $item->get_description(),
                category: $item->get_category()->get_term(),
                published_at: Carbon::parse($item->get_date()),
            ));
        }

        return $orders;
    }
}
