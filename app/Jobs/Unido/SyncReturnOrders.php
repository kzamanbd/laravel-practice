<?php

namespace App\Jobs\Unido;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SyncReturnOrders implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
            $mstRecords = Storage::disk('unido-ftp')->get('Unido/ReturnOrders/UND_ReturnOrders_Headers.csv');
            $mstRecords = explode("\n", $mstRecords);
            $mstRecords = array_map('str_getcsv', $mstRecords);
            // remove the header
            unset($mstRecords[0]);
            // ready the data for insertion
            $jsonData['header'] = collect($mstRecords)->map(function ($item) {
                return [
                    "invoice_number" => $item[0],
                    "customer_po" => $item[1],
                    "invoice_date" => $item[2],
                    "cr_ref_invoice" => $item[3],
                    "ref_iv_date" => $item[4],
                    "customer_code" => $item[5],
                    "wh_code" => $item[6],
                    "inv_pay_term" => $item[7],
                    "net_sales" => $item[8],
                    "inv_tax" => $item[9],
                    "inv_discount" => $item[10],
                    "cr_memo_reason" => $item[11],
                    "dist_ref_id" => $item[12],
                    "status" => $item[13]
                ];
            });

            // detail records
            $detailRecords = Storage::disk('unido-ftp')->get('Unido/ReturnOrders/UND_ReturnOrders_Lines.csv');
            $detailRecords = explode("\n", $detailRecords);
            $detailRecords = array_map('str_getcsv', $detailRecords);
            // remove the header
            unset($detailRecords[0]);
            // ready the data for insertion
            $jsonData['details'] = collect($detailRecords)->map(function ($item) {
                return [
                    "return_no" => $item[0],
                    "cust_po_no" => $item[1],
                    "return_line_no" => $item[2],
                    "return_date" => $item[3],
                    "cr_ref_inv" => $item[4],
                    "ref_inv_date" => $item[5],
                    "item_code" => $item[6],
                    "batch_lot" => $item[7],
                    "busi_div" => $item[8],
                    "line_type" => $item[9],
                    "ret_qty" => $item[10],
                    "list_price" => $item[11],
                    "inv_line_value" => $item[12],
                    "ret_discount" => $item[13],
                    "ret_vat" => $item[14],
                    "dist_ref_id" => $item[15],
                    "status" => $item[16],
                ];
            });

            // insert into database here
            DB::table('unido_sales_return_header')->insert($jsonData['header']->toArray());
            DB::table('unido_sales_return_lines')->insert($jsonData['details']->toArray());
            Log::info('Return orders synced successfully');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
