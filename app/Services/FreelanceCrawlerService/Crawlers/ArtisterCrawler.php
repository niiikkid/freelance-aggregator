<?php

namespace App\Services\FreelanceCrawlerService\Crawlers;

use App\Enums\FreelanceEnum;
use App\Services\FreelanceCrawlerService\ValueObject\FeedItemValue;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Weidner\Goutte\GoutteFacade;

class ArtisterCrawler extends BaseCrawler
{
    public function __construct(
        protected string $task_link
    )
    {}

    public function getSourceName(): FreelanceEnum
    {
        return FreelanceEnum::ARTISTER;
    }

    /**
     * @return Collection<int, FeedItemValue>
     */
    public function crawl(): Collection
    {
        $feed = $this->getFeed();

        $orders = collect();
        foreach ($feed as $item) {
            $orders->push(
                new FeedItemValue(
                    guid: $item['guid'],
                    title: html_entity_decode($item['title']),
                    link: 'https://artister.ru/task' . $item['link'],
                    description: html_entity_decode($item['description']),
                    category: html_entity_decode($item['category']),
                    published_at: Carbon::parse($item['published_at']),
                )
            );
        }

        return $orders;
    }

    protected function getFeed(): array
    {
        /**
         * @var \Symfony\Component\DomCrawler\Crawler $crawler
         */
        $crawler = GoutteFacade::request('GET', $this->task_link);

        $feed = [];
        $crawler->filter('.container .row .col .card-body')
            ->each(function (\Symfony\Component\DomCrawler\Crawler $node) use (&$feed) {
                $feed[] = [
                    'guid' => $node->filter('.task_name')->attr('href'),
                    'title' => $node->filter('.task_name')->attr('href'),
                    'link' => $node->filter('.task_name')->text(),
                    'description' => $node->filter('.clamp-line')->text(),
                    'category' => $node->filter('div')->last()->text(),
                    'published_at' => now()->toDateTimeString(),
                ];
            });

        return $feed;
    }
}
