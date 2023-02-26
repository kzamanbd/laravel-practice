<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

abstract class BaseExportFromView implements FromView, ShouldAutoSize, WithEvents
{
    protected string $freezeRow;
    protected string $autoFilter;

    public function registerEvents(): array
    {
        // after sheet rows grouping
        return [
            AfterSheet::class => function (AfterSheet $event) {
                if (isset($this->freezeRow)) {
                    $event->sheet->getDelegate()->freezePane($this->freezeRow);
                }
                if (isset($this->autoFilter)) {
                    $event->sheet->getDelegate()->setAutoFilter($this->autoFilter);
                }
            },
        ];
    }
}
