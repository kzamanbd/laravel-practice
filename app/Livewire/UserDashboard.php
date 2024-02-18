<?php

namespace App\Livewire;

use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;
use PhpOffice\PhpSpreadsheet\IOFactory;

class UserDashboard extends Component
{
    public function uploadExcel(): void
    {
        $path = public_path('docs/national-target-dec-2023.xlsx');

        $reader = IOFactory::createReader('Xlsx');
        $reader->setLoadAllSheets();
        $spreadsheet = $reader->load($path);
        $worksheet = $spreadsheet->getActiveSheet(); //Selecting The Active Sheet
        $highest_row = $worksheet->getHighestRow();
        $highest_col = 'E';

        $highest_cell = $highest_col . $highest_row;
        $rang = 'A1:' . $highest_cell; // Selecting The Cell Range

        // get data and cell formulas active sheet

        $dataToArray = $spreadsheet->getActiveSheet()->rangeToArray(
            $rang, // The worksheet range that we want to retrieve
            null, // Value that should be returned for empty cells
            false, // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
            true, // Should values be formatted (the equivalent of getFormattedValue() for each cell)
            true  // Should the array be indexed by cell row and cell column
        );

        $fields = ['sl', 'region', 'blank_field', 'target_share', 'formula'];

        $data = array_map(fn($row) => array_combine($fields, $row), $dataToArray);

        dd($data);
    }


    public function render()
    {
        return view('livewire.user-dashboard');
    }
}
