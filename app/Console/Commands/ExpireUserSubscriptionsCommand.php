<?php

namespace App\Console\Commands;

use App\Models\UserSubscription;
use App\Support\Enums\User\UserSubscriptionStatusEnum;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ExpireUserSubscriptionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark user subscriptions as ended when their end_date has passed';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $expiredCount = UserSubscription::query()
            ->where('status', UserSubscriptionStatusEnum::Active)
            ->where('end_date', '<', Carbon::today())
            ->update(['status' => UserSubscriptionStatusEnum::Ended->value]);

        $this->info("Expired {$expiredCount} subscription(s).");

        return self::SUCCESS;
    }
}
