<?php

namespace App\Services\FreelanceCrawlerService\Crawlers;

use App\Enums\FreelanceEnum;
use App\Services\FreelanceCrawlerService\ValueObject\FeedItemValue;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use SimplePie\SimplePie;
use Vedmant\FeedReader\Facades\FeedReader;

class FreelanceCrawler extends BaseCrawler
{
    public function __construct(
        protected string $rss_url
    )
    {}

    public function getSourceName(): FreelanceEnum
    {
        return FreelanceEnum::FREELANCE;
    }

    /**
     * @return Collection<int, FeedItemValue>
     */
    public function crawl(): Collection
    {
        $feed = $this->getFeed();

        $orders = collect();
        foreach ($feed->get_items() as $item) {
            $orders->push(
                new FeedItemValue(
                    guid: $item->get_id(),
                    title: html_entity_decode($item->get_title()),
                    link: $item->get_link(),
                    description: html_entity_decode($item->get_description()),
                    category: html_entity_decode($item->get_category()->get_term()),
                    published_at: Carbon::parse($item->get_date()),
                )
            );
        }

        return $orders;
    }

    protected function getFeed(): SimplePie
    {
        return FeedReader::read($this->rss_url);
    }
}
