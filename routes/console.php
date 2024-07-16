<?php

use App\Console\Commands\SendEmailsCommand;
use App\Jobs\Unido\SyncDailySalesCollectionReturn;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command(SendEmailsCommand::class)->hourly();

Schedule::job(SyncDailySalesCollectionReturn::class)->everyMinute();
