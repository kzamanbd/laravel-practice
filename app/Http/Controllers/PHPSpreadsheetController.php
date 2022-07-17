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
        $contacts = array_map(function ($row) {
            $row['created_at'] = now();
            $row['updated_at'] = now();
            return $row;
        }, $data);

        Contact::insert($contacts);
        return back()->with("success", "Data Successfully Imported");
    }

    public function show()
    {
        $contacts = Contact::all();
        return view('excel.export', compact('contacts'));
    }
    public function export()
    {
        $data[] = [
            'sl' => 'SL',
            'e_tin' => 'e-TIN',
            'tin_date' => 'TIN Date',
            'name' => 'Name',
            'mobile' => 'Mobile',
            'address' => 'Address',
            'police_station' => 'Police Station',
            'old_tin' => 'Old TIN',
            'circle_name' => 'Circle Name',
        ];

        $records = Contact::query()->latest()->get();

        foreach ($records as $index => $row) {
            $record = [
                'sl' => $index + 1,
                'e_tin' => $row->e_tin,
                'tin_date' => date("d/m/Y", strtotime($row->tin_date)),
                'name' => $row->name,
                'mobile' => $row->mobile ? Str::substr($row->mobile, -11) : '',
                'address' => $row->address,
                'police_station' => $row->police_station,
                'old_tin' => $row->old_tin,
                'circle_name' => $row->circle_name,
            ];

            $data[] = $record;
        }
        // create spreadsheet object
        $spreadsheet = new Spreadsheet();

        // add dataset
        $spreadsheet->getActiveSheet()->fromArray($data);

        // create xlsx file
        $date = now()->format('d-M-Y-H-i-s');
        $filename = "{$date}.xlsx";

        try {
            $writer = new Xlsx($spreadsheet);
            $writer->save($filename);
            $content = file_get_contents($filename);
        } catch (Exception $e) {
            exit($e->getMessage());
        }
        header("Content-Disposition: attachment; filename=" . $filename);
        unlink($filename);
        exit($content);
    }
}
