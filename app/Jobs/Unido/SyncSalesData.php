<?php

namespace App\Jobs\Unido;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class SyncSalesData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
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

        try {
            // Dispatch child jobs
            $batch = Bus::batch([
                new SyncSalesInvoice(),
                new SyncReturnOrders(),
                new SyncSalesCollection(),
            ])->then(function ($batch) {
                // All child jobs completed successfully
            })->catch(function ($batch, $e) {
                // All child jobs completed successfully
            })->finally(function ($batch) {
                // All child jobs completed successfully
            })->dispatch();

            Log::info('Batch ID: ' . $batch->id);
        } catch (\Exception $e) {
            Log::error('Transaction failed: ' . $e->getMessage());
            throw $e;
        }
    }
}
