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

class SyncSalesInvoice implements ShouldQueue
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
            // master record
            $mstRecords = Storage::disk('unido-ftp')->get('Unido/SalesOrders/UND_SalesOrders_Headers.csv');
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
                    "customer_code" => $item[3],
                    "wh_code" => $item[4],
                    "inv_pay_term" => $item[5],
                    "net_sales" => $item[6],
                    "inv_tax" => $item[7],
                    "inv_discount" => $item[8],
                    "dist_ref_id" => $item[9],
                    "status" => $item[10]
                ];
            });

            // detail record
            $detailRecords = Storage::disk('unido-ftp')->get('Unido/SalesOrders/UND_SalesOrders_Lines.csv');
            $detailRecords = explode("\n", $detailRecords);
            $detailRecords = array_map('str_getcsv', $detailRecords);
            // remove the header
            unset($detailRecords[0]);
            // ready the data for insertion
            $jsonData['details'] = collect($detailRecords)->map(function ($item) {
                return [
                    "invoice_number" => $item[0],
                    "customer_po" => $item[1],
                    "inv_line" => $item[2],
                    "invoice_date" => $item[3],
                    "mkt_code" => $item[4],
                    "lot_no" => $item[5],
                    "busi_division" => $item[6],
                    "line_typev" => $item[7],
                    "qty_req" => $item[8],
                    "trans_qty" => $item[9],
                    "list_price" => $item[10],
                    "inv_line_value" => $item[11],
                    "tot_discount" => $item[12],
                    "ind_item_tax" => $item[13],
                    "approval_no" => $item[14],
                    "dist_ref_id" => $item[15],
                    "status" => $item[16]
                ];
            });

            // insert into database here
            DB::table('unido_sales_invoice_header')->insert($jsonData['header']->toArray());
            DB::table('unido_sales_invoice_lines')->insert($jsonData['details']->toArray());
            DB::commit();
            Log::info('Sales data synced successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
