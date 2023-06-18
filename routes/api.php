<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::any('test', function () {
    $feed = make(\App\Services\FreelanceCrawlerService\FreelanceCrawlerServiceContract::class)
        ->crawl(
            new \App\Services\FreelanceCrawlerService\Crawlers\FreelanceCrawler()
        );

    return $feed->toArray();
});