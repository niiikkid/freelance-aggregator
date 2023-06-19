<?php

namespace App\Services\OrderCollector\Jobs;

use App\Contracts\FreelanceCrawlerServiceContract;
use App\Enums\QueueEnum;
use App\Models\Order;
use App\Services\FreelanceCrawlerService\Crawlers\BaseCrawler;
use App\Services\FreelanceCrawlerService\ValueObject\FeedItemValue;
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
        $this->onQueue(QueueEnum::ORDERS_COLLECTOR->value);
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
                Order::query()->firstOrCreate(
                    [
                        'external_id' => $feedItemValue->guid,
                        'freelance' => $orders->freelance,
                    ],
                    [
                        'external_id' => $feedItemValue->guid,
                        'freelance' => $orders->freelance,
                        'title' => $feedItemValue->title,
                        'link' => $feedItemValue->link,
                        'description' => $feedItemValue->description,
                        'category' => $feedItemValue->category,
                        'published_at' => $feedItemValue->published_at,
                    ]
                );
            });
        });
    }
}
