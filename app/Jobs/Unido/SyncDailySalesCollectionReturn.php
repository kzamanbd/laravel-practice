<?php

namespace App\Jobs\Unido;

use App\Mail\UnidoSalesDataSyncMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class SyncDailySalesCollectionReturn implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const COLLECTION_TABLE = 'unido_inv_collection';
    const SALES_RETURN_HEADER_TABLE = 'unido_sales_return_header';
    const SALES_RETURN_LINES_TABLE = 'unido_sales_return_lines';
    const SALES_INVOICE_HEADER_TABLE = 'unido_sales_invoice_header';
    const SALES_INVOICE_LINES_TABLE = 'unido_sales_invoice_lines';


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

            // sales invoice
            $salesInvoice = $this->processSalesInvoice();
            // insert into database here
            DB::table(self::SALES_INVOICE_HEADER_TABLE)->insert($salesInvoice[0]);
            DB::table(self::SALES_INVOICE_LINES_TABLE)->insert($salesInvoice[1]);
            Log::info('Sales invoice synced successfully');

            // sales return orders
            $salesReturn = $this->processReturnOrders();
            // insert into database here
            DB::table(self::SALES_RETURN_HEADER_TABLE)->insert($salesReturn[0]);
            DB::table(self::SALES_RETURN_LINES_TABLE)->insert($salesReturn[1]);
            Log::info('Return orders synced successfully');

            // collections
            $collections = $this->processCollections();
            // insert into database here
            DB::table(self::COLLECTION_TABLE)->insert($collections);
            Log::info('Collection data inserted successfully');


            // backup files to unido-ftp server
            // $this->backupFiles();
            Log::info('Files backed up successfully');

            Mail::to('kzamanbn@gmail.com')->send(new UnidoSalesDataSyncMail());

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error syncing return orders: ' . $e->getMessage());
        }
    }

    /**
     * Process sales invoice
     * @return array
     */
    public function processSalesInvoice()
    {
        // master record
        $mstRecords = Storage::disk('unido-ftp')->get('Unido/SalesOrders/UND_SalesOrders_Headers.csv');
        $mstRecords = explode("\n", $mstRecords);
        $mstRecords = array_map('str_getcsv', $mstRecords);
        // remove the header
        unset($mstRecords[0]);
        // ready the data for insertion
        $mstRecords = collect($mstRecords)->map(function ($item) {
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
        })->toArray();

        // detail record
        $detailRecords = Storage::disk('unido-ftp')->get('Unido/SalesOrders/UND_SalesOrders_Lines.csv');
        $detailRecords = explode("\n", $detailRecords);
        $detailRecords = array_map('str_getcsv', $detailRecords);
        // remove the header
        unset($detailRecords[0]);
        // ready the data for insertion
        $detailRecords = collect($detailRecords)->map(function ($item) {
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
        })->toArray();

        return [$mstRecords, $detailRecords];
    }

    /**
     * Process return orders
     * @return array
     */
    public function processReturnOrders()
    {
        // master records
        $mstRecords = Storage::disk('unido-ftp')->get('Unido/ReturnOrders/UND_ReturnOrders_Headers.csv');
        $mstRecords = explode("\n", $mstRecords);
        $mstRecords = array_map('str_getcsv', $mstRecords);
        // remove the header
        unset($mstRecords[0]);
        // ready the data for insertion
        $mstRecords = collect($mstRecords)->map(function ($item) {
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
        })->toArray();

        // detail records
        $detailRecords = Storage::disk('unido-ftp')->get('Unido/ReturnOrders/UND_ReturnOrders_Lines.csv');
        $detailRecords = explode("\n", $detailRecords);
        $detailRecords = array_map('str_getcsv', $detailRecords);
        // remove the header
        unset($detailRecords[0]);
        // ready the data for insertion
        $detailRecords = collect($detailRecords)->map(function ($item) {
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
        })->toArray();

        return [$mstRecords, $detailRecords];
    }

    /**
     * Process collections
     * @return array
     */
    public function processCollections()
    {
        $mstRecords = Storage::disk('unido-ftp')->get('Unido/Collection/UND_CustomerCollections.csv');
        $mstRecords = explode("\n", $mstRecords);
        $mstRecords = array_map('str_getcsv', $mstRecords);
        // remove the header
        unset($mstRecords[0]);
        // ready the data for insertion
        return collect($mstRecords)->map(function ($item) {
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
                "status" => $item[10],
            ];
        })->toArray();
    }

    /**
     * Backup files to unido-ftp server
     */
    public function backupFiles()
    {
        $today = date('Y-m-d');
        Storage::disk('unido-ftp')->copy('Unido/SalesOrders/UND_SalesOrders_Headers.csv', "Unido/Backup/$today/SalesOrders/UND_SalesOrders_Headers.csv");
        Storage::disk('unido-ftp')->copy('Unido/SalesOrders/UND_SalesOrders_Lines.csv', "Unido/Backup/$today/SalesOrders/UND_SalesOrders_Lines.csv");
        Storage::disk('unido-ftp')->copy('Unido/ReturnOrders/UND_ReturnOrders_Headers.csv', "Unido/Backup/$today/ReturnOrders/UND_ReturnOrders_Headers.csv");
        Storage::disk('unido-ftp')->copy('Unido/ReturnOrders/UND_ReturnOrders_Lines.csv', "Unido/Backup/$today/ReturnOrders/UND_ReturnOrders_Lines.csv");
        Storage::disk('unido-ftp')->copy('Unido/Collection/UND_CustomerCollections.csv', "Unido/Backup/$today/Collection/UND_CustomerCollections.csv");
    }
}
