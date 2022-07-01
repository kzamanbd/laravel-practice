<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PHPSpreadsheetController extends Controller
{
    public function index()
    {
        return view('excel.import');
    }

    public function preview(Request $request)
    {

        if ($request->file('file')) {
            $this->validate($request, [
                'file' => 'required|file|mimes:xlsx'
            ]);
            $path = $request->file('file')->store('documents');
            $url = Storage::url($path);
        } else {
            $url = public_path('docs/data.xlsx');
        }

        $reader = IOFactory::createReader("Xlsx");
        $reader->setLoadAllSheets();
        $spreadsheet = $reader->load($url);
        $worksheet = $spreadsheet->getActiveSheet(); //Selecting The Active Sheet
        $highest_row = $worksheet->getHighestRow();
        $highest_col = "H";

        $highest_cell = $highest_col . $highest_row;
        $rang = "A2:" . $highest_cell; // Selecting The Cell Range

        $dataToArray = $spreadsheet->getActiveSheet()->rangeToArray(
            $rang,              // The worksheet range that we want to retrieve
            NULL,       // Value that should be returned for empty cells
            TRUE, // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
            TRUE,      // Should values be formatted (the equivalent of getFormattedValue() for each cell)
            TRUE      // Should the array be indexed by cell row and cell column
        );
        $fields = ["e_tin", "tin_date", "name", "mobile", "address", "police_station", "old_tin", "circle_name"];
        $data = array_map(function ($row) use ($fields) {
            //Combining key value pair;
            return array_combine($fields, $row);
        }, $dataToArray);

        //return $data;
        $data = array_map(function ($item) {
            if (trim($item["tin_date"]) != null) {
                $d = Carbon::createFromFormat("d/m/Y", $item["tin_date"]);
                $item["tin_date"] = $d->format("d-M-Y");
            }
            return $item;
        }, $data);

        ($request->file) && Storage::exists($path) ? Storage::delete($path) : '';
        // return $data;
        session()->flash("success", "Data Successfully Imported, Please Confirm!");

        return view('excel.import', compact('data'));
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'data' => 'required'
        ]);
        $data = json_decode($request->data, true);
        $asses = array_map(function ($row) {
            $row['created_at'] = now();
            $row['updated_at'] = now();
            return $row;
        }, $data);

        Contact::insert($asses);
        return back()->with("success", "Data Successfully Imported");
    }

    public function show()
    {
        $columns = [
            'layer' => 'Layer',
            'sl' => 'SL',
            'territory_code' => 'Code',
            'territory_name' => 'Territory Name',
            'employee_id' => 'ID',
            'employee_name' => 'Name',
            'designation' => 'Designation',
            'opening' => 'Opening',
            'target' => 'Target',
            'no_of_inv' => 'No of Inv',
            'dispatch' => 'Dispatch',
            'return' => 'Return',
            'return_percentage' => 'Return %',
            'discount' => 'Discount',
            'actual_sales' => 'Actual Sales',
            'vat' => 'Vat',
            'net_sales' => 'Net Sales',
            'previous_collection' => 'Pre Collection',
            'current_collection' => 'Curr Collection',
            'in_transit' => 'In Transit',
            'cr_note' => 'Cr Note',
            'out_standing' => 'Outstanding',
            'sales_percentage' => 'Sales %',
            'collection_percentage' => 'Collection %',
        ];

        $collections[] = $columns;
        
        $json_path = public_path('sales-reports.json');
        $jsonRecords = collect(json_decode(file_get_contents($json_path), true));

        $records = $jsonRecords['data']['bu_data'];

        $mioCount = 1;
        $amCount = 1;
        $rsmCount = 1;
        foreach($records as $key => $record) {
            foreach($record['rsm_info'] as $rsmKey => $rsmInfo){
                foreach($rsmInfo['am_data'] as $amKey => $amData){
                    foreach($amData['mio_data'] as $mioKey => $mioData){
                        $collections[] = [
                            'layer' => 'MIO',
                            'sl' => $mioCount,
                            'territory_code' => $mioData['mio_area_code'],
                            'territory_name' => $mioData['mio_area_name'],
                            'employee_id' => $mioData['mio_code'],
                            'employee_name' => $mioData['mio_name'],
                            'designation' => $mioData['mio_desig'],
                            'opening' => $mioData['opening_dues'],
                            'target' => $mioData['mio_target'],
                            'no_of_inv' => $mioData['no_of_inv'],
                            'dispatch' => $mioData['dispatch'],
                            'return' => $mioData['return_total'],
                            'return_percentage' => $mioData['return_percent'],
                            'discount' => $mioData['discount'],
                            'actual_sales' => $mioData['actual_sales'],
                            'vat' => $mioData['inv_vat'],
                            'net_sales' => $mioData['net_sales'],
                            'previous_collection' => $mioData['prev_coll'],
                            'current_collection' => $mioData['curr_coll'],
                            'in_transit' => $mioData['in_transit_coll'],
                            'cr_note' => $mioData['credit_note'],
                            'out_standing' => $mioData['total_outstandings'],
                            'sales_percentage' => $mioData['sales_achvmnt'],
                            'collection_percentage' => $mioData['coll_achvmnt'],
                        ];

                        $mioCount++;
                    }

                    $collections[] = [
                        'layer' => 'AM',
                        'sl' => $amCount,
                        'territory_code' => $amData['am_area_code'],
                        'territory_name' => $amData['am_area_name'],
                        'employee_id' => $amData['am_code'],
                        'employee_name' => $amData['am_name'],
                        'designation' => $amData['am_desig'],
                        'opening' => $amData['opening_dues'],
                        'target' => $amData['am_target'],
                        'no_of_inv' => $amData['am_no_of_inv'],
                        'dispatch' => $amData['dispatch'],
                        'return' => $amData['return_total'],
                        'return_percentage' => $amData['return_percent'],
                        'discount' => $amData['discount'],
                        'actual_sales' => $amData['actual_sales'],
                        'vat' => $amData['inv_vat'],
                        'net_sales' => $amData['net_sales'],
                        'previous_collection' => $amData['prev_coll'],
                        'current_collection' => $amData['curr_coll'],
                        'in_transit' => $amData['in_transit_coll'],
                        'cr_note' => $amData['credit_note'],
                        'out_standing' => $amData['total_outstandings'],
                        'sales_percentage' => $amData['sales_achvmnt'],
                        'collection_percentage' => $amData['coll_achvmnt'],
                    ];

                    $amCount++;
                }

                $collections[] = [
                    'layer' => 'RSM',
                    'sl' => $rsmCount,
                    'territory_code' => $rsmInfo['rsm_area_code'],
                    'territory_name' => $rsmInfo['rsm_area_name'],
                    'employee_id' => $rsmInfo['rsm_code'],
                    'employee_name' => $rsmInfo['rsm_name'],
                    'designation' => $rsmInfo['rsm_desig'],
                    'opening' => $rsmInfo['opening_dues'],
                    'target' => $rsmInfo['rsm_target'],
                    'no_of_inv' => $rsmInfo['rsm_no_of_inv'],
                    'dispatch' => $rsmInfo['dispatch'],
                    'return' => $rsmInfo['return_total'],
                    'return_percentage' => $rsmInfo['return_percent'],
                    'discount' => $rsmInfo['discount'],
                    'actual_sales' => $rsmInfo['actual_sales'],
                    'vat' => $rsmInfo['inv_vat'],
                    'net_sales' => $rsmInfo['net_sales'],
                    'previous_collection' => $rsmInfo['prev_coll'],
                    'current_collection' => $rsmInfo['curr_coll'],
                    'in_transit' => $rsmInfo['in_transit_coll'],
                    'cr_note' => $rsmInfo['credit_note'],
                    'out_standing' => $rsmInfo['total_outstandings'],
                    'sales_percentage' => $rsmInfo['sales_achvmnt'],
                    'collection_percentage' => $rsmInfo['coll_achvmnt'],
                ];
                $rsmCount++;
            }
        }

        // create spreadsheet object
        $spreadsheet = new Spreadsheet();
        // add dataset
        $spreadsheet->getActiveSheet()->fromArray($collections);
        // create xlsx file
        $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
        $date = str_replace(".", "", $date);
        $filename = "Sales-Reports-{$date}.xlsx";

        try {
            $writer = new Xlsx($spreadsheet);
            $writer->save($filename);
            $content = file_get_contents($filename);
        } catch(Exception $e) {
            exit($e->getMessage());
        }
        header("Content-Disposition: attachment; filename=".$filename);
        unlink($filename);
        exit($content);

        // download file
        //return Storage::download($name);

        $asses = Contact::all();
        return view('excel.export', compact('asses'));
    }
    public function export(Request $request)
    {

        $data[0] = [
            'sl' => 'SL',
            'e_tin' => 'e-TIN',
            'tin_date' => 'TIN Date',
            'asses_name' => 'Asses Name',
            'mobile' => 'Mobile',
            'address' => 'Address',
            'police_station' => 'Police Station',
            'old_tin' => 'Old TIN',
            'circle_name' => 'Circle Name',
        ];

        $records = Contact::all();

        foreach ($records as $index => $row) {
            $record = [
                'sl' => $index + 1,
                'e_tin' => $row->e_tin,
                'tin_date' => date("d/m/Y", strtotime($row->tin_date)),
                'asses_name' => $row->asses_name,
                'mobile' => $row->mobile ? Str::substr($row->mobile, -11) : '',
                'address' => $row->address,
                'police_station' => $row->police_station,
                'old_tin' => $row->old_tin,
                'circle_name' => $row->circle_name,
            ];

            $data[$index + 1] = $record;
        }
        // create spreadsheet object
        $spreadsheet = new Spreadsheet();

        // add dataset
        $spreadsheet->getActiveSheet()->fromArray($data);

        // create xlsx file
        $writer = new Xlsx($spreadsheet);
        $name = 'export-excel/sheet-' . time() . '.xlsx';
        $path = storage_path('app/public/' . $name);

        if (!Storage::exists('export-excel')) {
            Storage::makeDirectory('export-excel', 0777, true);
        }
        $writer->save($path);
        // download file
        return Storage::download($name);
    }
}
