<?php

namespace App\Http\Livewire;

use App\Models\Contact;
use Carbon\Carbon;
use Livewire\Component;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Livewire\WithFileUploads;
use Storage;

class ContactList extends Component
{

    use WithFileUploads;

    public $openModal, $perPage = 25;
    public $excelFile;

    public function upload()
    {
        $this->validate([
            'excelFile' => 'nullable|file|mimes:xlsx'
        ]);
        // dd($this->excelFile);
        if ($this->excelFile) {
            $path = Storage::put('documents', $this->excelFile);
            $url = Storage::url($path);
        } else {
            $url = public_path('docs/excel-format.xlsx');
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

        dd($data);
    }


    public function getContactsProperty()
    {
        return Contact::query()->paginate($this->perPage);
    }
    public function render()
    {
        return view('livewire.contact-list')
            ->layoutData(['title' => 'Contact List']);
    }
}
