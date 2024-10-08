<?php

namespace App\Livewire;

use Carbon\Carbon;
use App\Exports\ContactExport;
use App\Models\Contact;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ContactManagement extends Component
{

    use WithFileUploads, WithPagination;

    public int $perPage = 20;

    public $excelFile;

    public array $excelData = [];
    public string $searchKey;

    protected $rules = [
        'excelFile' => 'nullable|file|mimes:xlsx',
    ];

    #[On('echo:reverb-channel,ReverbConnected')]
    public function reverbConnected($data): void
    {
        dd($data);
    }

    public function uploadHandler(): void
    {
        $this->validate();

        if ($this->excelFile) {
            $path = Storage::put('documents', $this->excelFile);
            $url = storage_path("app/public/{$path}");
        } else {
            $url = public_path('docs/excel-format.xlsx');
        }

        $reader = IOFactory::createReader('Xlsx');
        $reader->setLoadAllSheets();
        $spreadsheet = $reader->load($url);
        $worksheet = $spreadsheet->getActiveSheet(); //Selecting The Active Sheet
        $highest_row = $worksheet->getHighestRow();
        $highest_col = 'H';

        $highest_cell = $highest_col . $highest_row;
        $rang = 'A2:' . $highest_cell; // Selecting The Cell Range

        $dataToArray = $spreadsheet->getActiveSheet()->rangeToArray(
            $rang, // The worksheet range that we want to retrieve
            null, // Value that should be returned for empty cells
            true, // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
            true, // Should values be formatted (the equivalent of getFormattedValue() for each cell)
            true  // Should the array be indexed by cell row and cell column
        );
        $fields = ['e_tin', 'tin_date', 'name', 'mobile', 'address', 'police_station', 'old_tin', 'circle_name'];
        $data = array_map(function ($row) use ($fields) {
            //Combining key value pair;
            return array_combine($fields, $row);
        }, $dataToArray);

        $this->excelData = array_map(function ($item) {
            if (trim($item['tin_date']) != null) {
                $d = Carbon::createFromFormat('d/m/Y', $item['tin_date']);
                $item['tin_date'] = $d->format('d-M-Y');
            }

            return $item;
        }, $data);

        $this->dispatch('close-modal', 'upload-modal');
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
            return Excel::download(new ContactExport, $filename, 'Csv');
        } else {
            return Excel::download(new ContactExport, $filename, 'Xlsx');
        }
    }

    public function getContactsProperty(): \Illuminate\Contracts\Pagination\LengthAwarePaginator|array
    {
        return (count($this->excelData) > 0) ? [] : Contact::query()->latest()->paginate($this->perPage);
    }

    public function render()
    {
        return view('livewire.contact-list');
    }
}
