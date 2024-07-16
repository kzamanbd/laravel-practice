<?php

namespace App\Jobs\Unido;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SyncSalesCollection implements ShouldQueue
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
        DB::beginTransaction();
        try {
            $jsonData = [];
            // master records
            $mstRecords = Storage::disk('unido-ftp')->get('Unido/Collection/UND_CustomerCollections.csv');
            $mstRecords = explode("\n", $mstRecords);
            $mstRecords = array_map('str_getcsv', $mstRecords);
            // remove the header
            unset($mstRecords[0]);
            // ready the data for insertion
            $jsonData['collection'] = collect($mstRecords)->map(function ($item) {
                return [
                    "wh_code" => $item[0],
                    "cust_code" => $item[1],
                    "inv_number" => $item[2],
                    "inv_value" => $item[3],
                    "pay_date" => $item[4],
                    "received_amt" => $item[5],
                    "pay_rcv_date" => $item[6],
                    "payment_type" => $item[7],
                    "journal_code" => $item[8],
                    "cust_po" => $item[9],
                    "STSTUS" => $item[10],
                ];
            });

            // insert into database here
            DB::table('unido_inv_collection')->insert($jsonData['collection']->toArray());
            Log::info('Collection data inserted successfully');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
