<?php

use App\Console\Commands\ExpireUserSubscriptionsCommand;
use Illuminate\Support\Facades\Schedule;

Schedule::command(ExpireUserSubscriptionsCommand::class)->dailyAt('00:01');
// Schedule::command('backup:run')->dailyAt('10:20');
