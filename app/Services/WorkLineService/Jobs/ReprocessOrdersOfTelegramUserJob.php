<?php

namespace App\Services\WorkLineService\Jobs;

use App\Contracts\OrderFilterServiceContract;
use App\Enums\QueueEnum;
use App\Models\Order;
use App\Models\TelegramUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ReprocessOrdersOfTelegramUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected TelegramUser $telegramUser
    )
    {
        $this->afterCommit();
        $this->onQueue(QueueEnum::WORK_LINE->value);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::transaction(function () {
            $this->telegramUser
                ->orders()
                ->wherePivot('reviewed', 0)
                ->get()
                ->each(function (Order $order) {
                $is_allowed = make(OrderFilterServiceContract::class)
                    ->isAllowed($order, $this->telegramUser);

                $order->telegramUsers()
                    ->wherePivot('reviewed', 0)
                    ->updateExistingPivot($this->telegramUser->id, [
                        'allowed' => $is_allowed,
                    ]);
            });
        });
    }
}
