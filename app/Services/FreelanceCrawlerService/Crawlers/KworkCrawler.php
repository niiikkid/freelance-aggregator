<?php

namespace App\Services\FreelanceCrawlerService\Crawlers;

use App\Enums\FreelanceEnum;
use App\Services\FreelanceCrawlerService\ValueObject\FeedItemValue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class KworkCrawler extends BaseCrawler
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

        $orders = collect();

        foreach ($pages as $page) {
            $feed = Http::asForm()->post(
                url: 'https://kwork.ru/projects',
                data: $page,
            )['data']['pagination']['data'];

            foreach ($feed as $item) {
                $orders->push(new FeedItemValue(
                    title: $item['name'],
                    link: 'https://kwork.ru/projects/' . $item['id'],
                    description: $item['desc'],
                    category: $item['attrs'][0]['title'],
                    published_at: \Carbon\Carbon::parse($item['date_create']),
                ));
            }
        }

        return $orders;
    }
}
