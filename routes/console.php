<?php

use App\Console\Commands\CreateWeeklyLeagues;
use App\Console\Commands\FixtureLiveDataCommand;
use App\Console\Commands\GetFixtureLineupCommand;
use App\Console\Commands\GetPlayersDataCommand;
use App\Console\Commands\GetTableRankingCommand;
use App\Console\Commands\SendScheduleNotification;
use App\Console\Commands\SetFixtureDateCommand;
use App\Console\Commands\SetFixtureExtraDataCommand;
use App\Console\Commands\SetSubPlayerInsteadOfMain;
use App\Console\Commands\SetUsersTeamWeekCommand;
use App\Console\Commands\SetUsersToPublicLeaguesCommand;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

//Artisan::command('inspire', function () {
//    $this->comment(Inspiring::quote());
//})->purpose('Display an inspiring quote')->hourly();


//Schedule::command('ranking:get')->everyMinute();
Schedule::command(GetTableRankingCommand::class)->dailyAt('21:00');
Schedule::command(GetPlayersDataCommand::class)->dailyAt('10:00');
Schedule::command(SetUsersTeamWeekCommand::class)->everyFiveMinutes();
//TODO::check data right at 22-08-2024 6PM
Schedule::command(GetFixtureLineupCommand::class)->everyFiveMinutes();
Schedule::command(SendScheduleNotification::class)->everyMinute();
Schedule::command(FixtureLiveDataCommand::class)->everyFiveMinutes();
Schedule::command(SetFixtureExtraDataCommand::class)->dailyAt('09:00');
Schedule::command(SetFixtureDateCommand::class)->dailyAt('10:00');
Schedule::command(SetUsersToPublicLeaguesCommand::class)->everyFourHours();
Schedule::command(CreateWeeklyLeagues::class)->everyFourHours();
//Schedule::command(SetSubPlayerInsteadOfMain::class)->dailyAt('23:00');
Schedule::command('backup:run')->dailyAt('20:45');
//Schedule::command('backup:run')->dailyAt('10:20');



