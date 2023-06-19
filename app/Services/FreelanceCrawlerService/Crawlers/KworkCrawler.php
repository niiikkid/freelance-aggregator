<?php

namespace App\Services\FreelanceCrawlerService\Crawlers;

use App\Enums\FreelanceEnum;
use App\Services\FreelanceCrawlerService\ValueObject\FeedItemValue;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class KworkCrawler extends BaseCrawler
{
    public function __construct(
        protected array $page
    )
    {}

    public function getSourceName(): FreelanceEnum
    {
        return FreelanceEnum::KWORK;
    }

    /**
     * @return Collection<int, FeedItemValue>
     */
    public function crawl(): Collection
    {
        $feed = $this->getFeed();

        $orders = collect();
        foreach ($feed as $item) {
            $orders->push(new FeedItemValue(
                guid: $item['id'],
                title: html_entity_decode($item['name']),
                link: 'https://kwork.ru/projects/' . $item['id'],
                description: html_entity_decode($item['desc']),
                category: html_entity_decode($item['attrs'][0]['title']),
                published_at: Carbon::parse($item['date_create']),
            ));
        }

        return $orders;
    }

    protected function getFeed(): mixed
    {
        return Http::asForm()->post(
            url: 'https://kwork.ru/projects',
            data: $this->page,
        )['data']['pagination']['data'];
    }
}
