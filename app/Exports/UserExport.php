<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class UserExport implements FromView, WithColumnWidths, WithEvents
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

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 30,
            'C' => 30,
            'D' => 20,
        ];
    }

    public function registerEvents(): array
    {
        // after sheet rows grouping
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setAutoFilter('A2:D2');
                // 10 rows grouping
                // $event->sheet->getDelegate()->groupRows(2, 11, 0);

                // get row dimension
                foreach (range(2, 11) as $row) {
                    $event->sheet->getDelegate()->getRowDimension($row)->setOutlineLevel(1);
                }
            },
        ];
    }
}
