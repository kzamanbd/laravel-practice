<?php

namespace App\Livewire;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

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
    public function render()
    {
        return view('livewire.job-batching');
    }
}
