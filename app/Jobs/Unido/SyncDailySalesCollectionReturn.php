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
use Illuminate\Support\Str;

class SyncDailySalesCollectionReturn implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const UNIDO_FTP = 'unido-ftp';

    const SALES_INVOICE_HEADER_TABLE = 'unido_sales_invoice_header';
    const SALES_INVOICE_LINES_TABLE = 'unido_sales_invoice_lines';
    const SALES_RETURN_HEADER_TABLE = 'unido_sales_return_header';
    const SALES_RETURN_LINES_TABLE = 'unido_sales_return_lines';
    const COLLECTION_TABLE = 'unido_inv_collection';


    const INV_HEADER = 'Unido/SalesOrders/UND_SalesOrders_Headers.csv';
    const INV_LINES = 'Unido/SalesOrders/UND_SalesOrders_Lines.csv';
    const RETURN_HEADER = 'Unido/ReturnOrders/UND_ReturnOrders_Headers.csv';
    const RETURN_LINES = 'Unido/ReturnOrders/UND_ReturnOrders_Lines.csv';
    const COLLECTION = 'Unido/Collection/UND_CustomerCollections.csv';



    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(protected bool $isProduction = false)
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
        if (!app()->isProduction() && !$this->isProduction) {
            return;
        }

        DB::beginTransaction();
        try {

            $chunkSize = 1000;

            // sales invoice
            $salesInvoice = $this->processSalesInvoice();
            // insert into database here $chunkSize chunks of data
            collect($salesInvoice[0])->chunk($chunkSize)->each(function ($chunk) {
                DB::table(self::SALES_INVOICE_HEADER_TABLE)->insert($chunk->toArray());
            });

            collect($salesInvoice[1])->chunk($chunkSize)->each(function ($chunk) {
                DB::table(self::SALES_INVOICE_LINES_TABLE)->insert($chunk->toArray());
            });
            Log::info('Sales invoice synced successfully');

            // sales return orders
            $salesReturn = $this->processReturnOrders();
            // insert into database here $chunkSize chunks of data
            collect($salesReturn[0])->chunk($chunkSize)->each(function ($chunk) {
                DB::table(self::SALES_RETURN_HEADER_TABLE)->insert($chunk->toArray());
            });

            collect($salesReturn[1])->chunk($chunkSize)->each(function ($chunk) {
                DB::table(self::SALES_RETURN_LINES_TABLE)->insert($chunk->toArray());
            });
            Log::info('Return orders synced successfully');

            // collections
            $collections = $this->processCollections();
            // insert into database here $chunkSize chunks of data
            collect($collections)->chunk($chunkSize)->each(function ($chunk) {
                DB::table(self::COLLECTION_TABLE)->insert($chunk->toArray());
            });
            Log::info('Collection data inserted successfully');

            // backup files to unido-ftp server
            $this->backupFiles();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            $message = Str::limit($e->getMessage(), 1000);
            Log::error('Error syncing unido data: ' . $message);
            SyncNotificationMail::dispatch($message);
        }
    }

    /**
     * Process sales invoice
     * @return array
     */
    public function processSalesInvoice()
    {
        // master record
        $mstRecords = Storage::disk(self::UNIDO_FTP)->get(self::INV_HEADER);
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
        $detailRecords = Storage::disk(self::UNIDO_FTP)->get(self::INV_LINES);
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
        $mstRecords = Storage::disk(self::UNIDO_FTP)->get(self::RETURN_HEADER);
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
        $detailRecords = Storage::disk(self::UNIDO_FTP)->get(self::RETURN_LINES);
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
        $mstRecords = Storage::disk(self::UNIDO_FTP)->get(self::COLLECTION);
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
                "ststus" => $item[10],
            ];
        })->toArray();
    }

    /**
     * Backup files to unido-ftp server
     */
    public function backupFiles()
    {
        $today = date('Y-m-d');
        Storage::disk(self::UNIDO_FTP)->copy(self::INV_HEADER, "Unido/Backup/$today/SalesOrders/UND_SalesOrders_Headers.csv");
        Storage::disk(self::UNIDO_FTP)->copy(self::INV_LINES, "Unido/Backup/$today/SalesOrders/UND_SalesOrders_Lines.csv");
        Storage::disk(self::UNIDO_FTP)->copy(self::RETURN_HEADER, "Unido/Backup/$today/ReturnOrders/UND_ReturnOrders_Headers.csv");
        Storage::disk(self::UNIDO_FTP)->copy(self::RETURN_LINES, "Unido/Backup/$today/ReturnOrders/UND_ReturnOrders_Lines.csv");
        Storage::disk(self::UNIDO_FTP)->copy(self::COLLECTION, "Unido/Backup/$today/Collection/UND_CustomerCollections.csv");
        Log::info('Files backed up successfully');
    }
}
