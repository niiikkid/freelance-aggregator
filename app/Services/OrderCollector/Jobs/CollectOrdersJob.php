<?php

namespace App\Services\OrderCollector\Jobs;

use App\Contracts\FreelanceCrawlerServiceContract;
use App\Contracts\OrderServiceContract;
use App\Services\FreelanceCrawlerService\Crawlers\BaseCrawler;
use App\Services\FreelanceCrawlerService\ValueObject\FeedItemValue;
use App\Services\OrderService\DTO\CreateOrderDTO;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CollectOrdersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected BaseCrawler $crawler
    )
    {
        $this->afterCommit();
        $this->onQueue('orders-collector');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $orders = make(FreelanceCrawlerServiceContract::class)
            ->crawl($this->crawler);

        DB::transaction(function () use ($orders) {
            $orders->items->each(function (FeedItemValue $feedItemValue) use ($orders) {
                make(OrderServiceContract::class)
                    ->create(
                        new CreateOrderDTO(
                            freelance: $orders->freelance,
                            title: $feedItemValue->title,
                            link: $feedItemValue->link,
                            description: $feedItemValue->description,
                            category: $feedItemValue->category,
                            published_at: $feedItemValue->published_at,
                        )
                    );
            });
        });
    }
}
