<?php

namespace App\Exports;

use Exception;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ContactExport implements FromView
{
    public static function downloadExcel(string $format)
    {
        $data[] = [
            'sl' => 'SL',
            'name' => 'Name',
            'mobile' => 'Mobile',
            'address' => 'Address',
            'e_tin' => 'E-TIN',
            'old_tin' => 'Old TIN',
            'tin_date' => 'TIN Date',
            'police_station' => 'Police Station',
            'circle_name' => 'Circle Name',
            'created_at' => 'Created At',
        ];

        $records = Contact::query()->latest()->get();

        foreach ($records as $index => $row) {
            $data[] = [
                'sl' => $index + 1,
                'name' => $row->name,
                'mobile' => $row->mobile,
                'address' => $row->address,
                'e_tin' => $row->e_tin,
                'old_tin' => $row->old_tin,
                'tin_date' => $row->tin_date,
                'police_station' => $row->police_station,
                'circle_name' => $row->circle_name,
                'created_at' => $row->created_at,
            ];
        }
        // create spreadsheet object
        $spreadsheet = new Spreadsheet();

        // add dataset
        $spreadsheet->getActiveSheet()->fromArray($data);

        // create xlsx file
        $date = now()->format('d-M-Y-H-i-s');
        $directoryName = 'documents';

        if (!Storage::exists($directoryName)) {
            Storage::makeDirectory($directoryName, 0777, true);
        }

        try {
            if ($format == 'xlsx') {
                $filename = "{$date}-contacts.xlsx";
                $path = "$directoryName/{$filename}";
                $writer = new Xlsx($spreadsheet);
                $writer->save(storage_path("app/public/$path"));
            } else {
                $filename = "{$date}-contacts.csv";
                $path = "$directoryName/{$filename}";
                $writer = new Csv($spreadsheet);
                $writer->save(storage_path("app/public/$path"));
            }
            // download file
            return Storage::download($path);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function view(): View
    {
        $contacts = Contact::query()->latest()->get();

        return view('exports.contacts', [
            'contacts' => $contacts
        ]);
    }
}
