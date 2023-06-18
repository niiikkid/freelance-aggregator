<?php

namespace App\Providers;

use App\Services\FreelanceCrawlerService\FreelanceCrawlerService;
use App\Services\FreelanceCrawlerService\FreelanceCrawlerServiceContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FreelanceCrawlerServiceContract::class, FreelanceCrawlerService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
