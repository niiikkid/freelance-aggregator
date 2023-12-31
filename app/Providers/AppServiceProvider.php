<?php

namespace App\Providers;

use App\Contracts\FreelanceCrawlerServiceContract;
use App\Contracts\OrderCollectorServiceContract;
use App\Contracts\OrderFilterServiceContract;
use App\Contracts\TelegramBotServiceContract;
use App\Contracts\WorkLineServiceContract;
use App\Services\FreelanceCrawlerService\FreelanceCrawlerService;
use App\Services\OrderCollector\OrderCollectorService;
use App\Services\OrderFilterService\OrderFilterService;
use App\Services\TelegramBotService\TelegramBotService;
use App\Services\WorkLineService\WorkLineService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FreelanceCrawlerServiceContract::class, FreelanceCrawlerService::class);
        $this->app->bind(OrderCollectorServiceContract::class, OrderCollectorService::class);
        $this->app->bind(OrderFilterServiceContract::class, OrderFilterService::class);
        $this->app->bind(TelegramBotServiceContract::class, TelegramBotService::class);
        $this->app->bind(WorkLineServiceContract::class, WorkLineService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
