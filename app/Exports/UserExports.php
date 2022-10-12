<?php

namespace App\Exports;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Csv;

class UserExports
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

        if (!Storage::exists('exports')) {
            Storage::makeDirectory('exports', 0777, true);
        }

        try {
            if ($format == 'xlsx') {
                $filename = "{$date}.xlsx";
                $path = "exports/{$filename}";
                $writer = new Xlsx($spreadsheet);
                $writer->save(storage_path("app/public/$path"));
            } else {
                $filename = "{$date}.csv";
                $path = "exports/{$filename}";
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
