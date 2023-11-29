<?php

namespace App\Livewire;

use Livewire\Component;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UserDashboard extends Component
{
    public function uploadExcel()
    {
        $path = public_path('docs/national-target-dec-2023.xlsx');

        $reader = IOFactory::createReader('Xlsx');
        $reader->setLoadAllSheets();
        $spreadsheet = $reader->load($path);
        $worksheet = $spreadsheet->getActiveSheet(); //Selecting The Active Sheet
        $highest_row = $worksheet->getHighestRow();
        $highest_col = 'E';

        $highest_cell = $highest_col . $highest_row;
        $rang = 'A9:' . $highest_cell; // Selecting The Cell Range

        // get data and cell formulas active sheet

        $dataToArray = $spreadsheet->getActiveSheet()->rangeToArray(
            $rang, // The worksheet range that we want to retrieve
            null, // Value that should be returned for empty cells
            false, // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
            true, // Should values be formatted (the equivalent of getFormattedValue() for each cell)
            true  // Should the array be indexed by cell row and cell column
        );


        $fields = ['sl', 'region', 'blank_field', 'target_share', 'formula'];

        // return $dataToArray;

        $data = array_map(function ($row) use ($fields) {
            //Combining key value pair;
            return array_combine($fields, $row);
        }, $dataToArray);

        dd($data);
    }
    public function render()
    {
        return view('livewire.user-dashboard');
    }
}
