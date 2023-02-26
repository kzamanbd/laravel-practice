<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class UserExport extends BaseExportFromView
{
    /**
     * @return View
     */
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
                $event->sheet->getDelegate()->setAutoFilter('A2:D2');
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
