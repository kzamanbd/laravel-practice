<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class RowGroupingExport extends BaseExportFromView
{
    protected string $freezePane = 'A3';
    protected string $autoFilter = 'B2:E2';

    public function view(): View
    {
        return view('exports.users', [
            'users' => User::query()->latest()->get()
        ]);
    }

    public function registerEvents(): array
    {
        // after sheet rows grouping
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setAutoFilter($this->autoFilter);
                $event->sheet->getDelegate()->freezePane($this->freezePane);
                // 10 rows grouping
                foreach (range(2, 15) as $row) {
                    $event->sheet->getDelegate()
                        ->getRowDimension($row)
                        ->setOutlineLevel(1)
                        ->setVisible(false)
                        ->setCollapsed(true);
                }
            },
        ];
    }
}
