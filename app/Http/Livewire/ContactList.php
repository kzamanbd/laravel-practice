<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use LaravelIdea\Helper\App\Models\_IH_Contact_C;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\Contact;
use App\Exports\ContactExport;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ContactList extends Component
{

    use WithFileUploads, WithPagination;

    public $openModal, $perPage = 25;
    public $excelFile, $excelData = [];

    public function upload(): void
    {
        $this->validate([
            'excelFile' => 'nullable|file|mimes:xlsx'
        ]);

        if ($this->excelFile) {
            $path = Storage::put('documents', $this->excelFile);
            $url = storage_path("app/public/{$path}");
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
            $rang, // The worksheet range that we want to retrieve
            NULL, // Value that should be returned for empty cells
            TRUE, // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
            TRUE, // Should values be formatted (the equivalent of getFormattedValue() for each cell)
            TRUE  // Should the array be indexed by cell row and cell column
        );
        $fields = ["e_tin", "tin_date", "name", "mobile", "address", "police_station", "old_tin", "circle_name"];
        $data = array_map(function ($row) use ($fields) {
            //Combining key value pair;
            return array_combine($fields, $row);
        }, $dataToArray);

        $this->excelData = array_map(function ($item) {
            if (trim($item["tin_date"]) != null) {
                $d = Carbon::createFromFormat("d/m/Y", $item["tin_date"]);
                $item["tin_date"] = $d->format("d-M-Y");
            }
            return $item;
        }, $data);

        $this->openModal = false;
    }

    public function confirmToImport(): void
    {
        if (count($this->excelData) > 0) {
            $contacts = array_map(function ($row) {
                $row['created_at'] = now();
                $row['updated_at'] = now();
                return $row;
            }, $this->excelData);
            Contact::insert($contacts);
            $this->excelData = [];
        }
    }

    public function exportExcel(string $type = 'xlsx'): BinaryFileResponse
    {
        $date = now()->format('d-M-Y-H-i-s');
        $filename = "contacts-$date.$type";

        if ($type == 'csv') {
            return Excel::download(new ContactExport, $filename, \Maatwebsite\Excel\Excel::CSV);
        } else {
            return Excel::download(new ContactExport, $filename, \Maatwebsite\Excel\Excel::XLSX);
        }
    }

    public function getContactsProperty(): \Illuminate\Contracts\Pagination\LengthAwarePaginator|LengthAwarePaginator|array|_IH_Contact_C
    {
        return (count($this->excelData) > 0) ? [] : Contact::query()->paginate($this->perPage);
    }

    public function render(): View
    {
        return view('livewire.contact-list')
            ->layoutData(['title' => 'Contact List']);
    }
}
