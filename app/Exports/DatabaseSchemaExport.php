<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class DatabaseSchemaExport implements FromArray, ShouldAutoSize
{

    public function __construct(private $array) {}

    public function array(): array
    {
        return $this->array;
    }

    // style first row of the excel sheet
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:H1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'startColor' => [
                            'rgb' => 'FF0000'
                        ]
                    ]
                ]);
            }
        ];
    }
}
