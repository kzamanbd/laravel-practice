<?php

namespace App\Exports;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class UserExport
{
    public static function downloadExcel(string $format)
    {
        // export excel

        $data[] = [
            'sl' => 'SL',
            'name' => 'Name',
            'email' => 'Email',
            'created_at' => 'Created At',
        ];

        $records = User::query()->latest()->get();

        foreach ($records as $index => $row) {
            $data[] = [
                'sl' => $index + 1,
                'name' => $row->name,
                'email' => $row->email,
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
                $filename = "{$date}-users.xlsx";
                $path = "$directoryName/{$filename}";
                $writer = new Xlsx($spreadsheet);
                $writer->save(storage_path("app/public/$path"));
            } else {
                $filename = "{$date}-users.csv";
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
}
