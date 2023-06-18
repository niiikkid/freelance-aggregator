<?php

namespace App\Services\WorkLineService\Jobs;

use App\Contracts\OrderFilterServiceContract;
use App\Models\Order;
use App\Models\TelegramUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ProcessOrderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected Order $order
    )
    {
        $this->afterCommit();
        $this->onQueue('work-line');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $telegramUsers = TelegramUser::all();

        DB::transaction(function () use ($telegramUsers) {
            $telegramUsers->each(function (TelegramUser $telegramUser) {
                $is_allowed = make(OrderFilterServiceContract::class)
                    ->isAllowed($this->order, $telegramUser);

                $telegramUser->orders()->attach([
                    $this->order->id => [
                        'allowed' => $is_allowed,
                        'reviewed' => false,
                    ],
                ]);
            });
        });
    }
}
