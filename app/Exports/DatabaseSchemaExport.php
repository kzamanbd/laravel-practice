<?php

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;

class DatabaseSchemaExport extends BaseExportFromView
{

    public function __construct(private $schema, private $tableName) {}

    public function view(): \Illuminate\Contracts\View\View
    {
        return view('exports.database-schema', [
            'schema' => $this->schema,
            'tableName' => $this->tableName
        ]);
    }

    // set cell height
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(50);
            }
        ];
    }
}
