<?php

namespace App\Jobs\Unido;

use App\Mail\Unido\DailySalesDataSyncFailed;
use App\Mail\Unido\DailySalesDataSyncSuccess;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SyncNotificationMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected $error = null)
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emails = ['kzamanbn@gmail.com'];

        if (isset($this->error)) {
            Mail::to($emails)->send(new DailySalesDataSyncFailed($this->error));
        } else {
            Mail::to($emails)->send(new DailySalesDataSyncSuccess());
        }
    }
}
