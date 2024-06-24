<?php

namespace Draftscripts\Permission\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

abstract class BaseExportFromView implements FromView, ShouldAutoSize, WithEvents
{
    protected string $freezePane;

    protected string $autoFilter;

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                if (isset($this->freezePane)) {
                    $event->sheet->getDelegate()->freezePane($this->freezePane);
                }
                if (isset($this->autoFilter)) {
                    $event->sheet->getDelegate()->setAutoFilter($this->autoFilter);
                }
            },
        ];
    }
}
