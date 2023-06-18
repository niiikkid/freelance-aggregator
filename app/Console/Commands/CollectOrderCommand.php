<?php

namespace App\Console\Commands;

use App\Contracts\OrderCollectorServiceContract;
use Illuminate\Console\Command;

class CollectOrderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order-collector:collect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        make(OrderCollectorServiceContract::class)->collect();
    }
}
