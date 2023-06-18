<?php

namespace App\Providers;

use App\Contracts\FreelanceCrawlerServiceContract;
use App\Contracts\OrderCollectorServiceContract;
use App\Contracts\OrderFilterServiceContract;
use App\Contracts\OrderServiceContract;
use App\Contracts\TelegramBotServiceContract;
use App\Services\FreelanceCrawlerService\FreelanceCrawlerService;
use App\Services\OrderCollector\OrderCollectorService;
use App\Services\OrderFilerService\OrderFilterService;
use App\Services\OrderService\OrderService;
use App\Services\TelegramBotService\TelegramBotService;
use App\Telegram\Commands\StartCommand;
use Illuminate\Support\ServiceProvider;
use Telegram\Bot\Laravel\Facades\Telegram;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FreelanceCrawlerServiceContract::class, FreelanceCrawlerService::class);
        $this->app->bind(OrderServiceContract::class, OrderService::class);
        $this->app->bind(OrderCollectorServiceContract::class, OrderCollectorService::class);
        $this->app->bind(OrderFilterServiceContract::class, OrderFilterService::class);
        $this->app->bind(TelegramBotServiceContract::class, TelegramBotService::class);

        //Telegram
        Telegram::addCommand(StartCommand::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
