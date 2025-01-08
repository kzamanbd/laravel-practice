<?php

namespace App\Livewire;

use App\Jobs\ExportCsvChunk;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Throwable;

class JobBatching extends Component
{
    use WithFileUploads;

    #[Validate('required:file|max:1024|mimes:csv,xlsx,xls')]
    public $file;

    public function updatedFile()
    {
        $this->validateOnly('file');
        dd($this->file->getRealPath());
    }

    public function downloadContacts()
    {
        $filename = 'contacts/Export_' . now()->timestamp . '.csv';
        $batches = [];
        DB::table('contacts')->latest()->chunk(10000, function ($rows) use (&$batches, $filename) {
            $batches[] = new ExportCsvChunk($rows->toArray(), $filename);
        });

        // Dispatch the batch of jobs
        $batch = Bus::batch($batches)->dispatch();

        dd(['message' => 'CSV export batch job has been dispatched.', 'batch_id' => $batch->id]);
    }

    public function render()
    {
        return view('livewire.job-batching');
    }
}
