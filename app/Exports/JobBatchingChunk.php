<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class JobBatchingChunk implements FromCollection
{
    public function __construct(private $data) {}

    public function headings(): array
    {
        return ['#', 'Name', 'Mobile', 'E-TIN', 'OLD-TIN', 'TIN Date']; // Replace with actual columns
    }

    /**
     * @return Collection
     */
    public function collection()
    {
        return collect($this->data);
    }
}
