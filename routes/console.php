<?php

use App\Console\Commands\SendEmailsCommand;
use App\Jobs\Unido\SyncSalesData;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command(SendEmailsCommand::class)->hourly();

Schedule::job(SyncSalesData::class)->dailyAt('8:00');
